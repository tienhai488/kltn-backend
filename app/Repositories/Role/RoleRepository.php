<?php

namespace App\Repositories\Role;

use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

/**
 * The repository for Role Model
 */
class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * @inheritdoc
     */
    protected $model;

    /**
     * @inheritdoc
     */
    public function __construct(Role $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    /**
     * @inheritdoc
     */
    public function allRolesWithPermissions()
    {
        return $this->model->with('permissions')->get();
    }

    /**
     * @inheritdoc
     */
    public function create($data)
    {
        try {
            DB::beginTransaction();

            $role = $this->model->findOrCreate($data['name']);
            $role->givePermissionTo($data['permissions']);

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function update($model, $data)
    {
        try {
            DB::beginTransaction();

            $model->update($data);
            $model->syncPermissions($data['permissions']);

            DB::commit();

            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function getRoleByName(string $name): Collection
    {
        return $this->model->where('name', $name)->get();
    }
}
