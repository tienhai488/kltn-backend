<?php

namespace App\Repositories\Permission;

use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

/**
 * The repository for Permission Model
 */
class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * @inheritdoc
     */
    protected $model;

    /**
     * @inheritdoc
     */
    public function __construct(Permission $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    /**
     * @inheritdoc
     */
    public function groupPermissions($permissions, $groups): Collection
    {
        $groupedPermissions = collect($permissions)->groupBy(function ($permission) use ($groups) {
            foreach ($groups as $group => $keywords) {
                if (Str::contains($permission->name, $keywords)) {
                    return $group;
                }
            }
            return __('Khác');
        });

        return $groupedPermissions;
    }
}