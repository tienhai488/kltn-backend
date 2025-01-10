<?php

namespace App\Repositories\Department;

use App\Models\Department;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * The repository for Department Model
 */
class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    const ITEM_PER_PAGE = 50;

    /**
     * {@inheritdoc}
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(Department $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    /**
     * {@inheritdoc}
     */
    public function serverPaginationFilteringForAdmin($searchParams): LengthAwarePaginator
    {
        $limit = Arr::get($searchParams, 'limit', self::ITEM_PER_PAGE);

        $query = $this->departmentFilter($searchParams);

        return $query->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function departmentFilter(array $searchParams): Builder|Department
    {
        $keyword = Arr::get($searchParams, 'search', '');
        $status = Arr::get($searchParams, 'status', null);

        $query = $this->model->query();

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereAny([
                'id',
                'code',
                'name',
            ], 'LIKE', '%' . $keyword . '%');
        }

        if (! is_null($status)) {
            $query->where('status', $status);
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function create($data)
    {
        try {
            DB::beginTransaction();

            $department = $this->model->create($data);

            if (isset($data['department_thumbnail']) && $data['department_thumbnail']) {
                $file = json_decode($data['department_thumbnail'], true);

                $department->addMediaFromBase64($file['data'])
                    ->usingFileName($file['name'])
                    ->toMediaCollection(Department::DEPARTMENT_THUMBNAIL_COLLECTION);
            }

            DB::commit();

            return $department;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update($model, $data)
    {
        try {
            DB::beginTransaction();

            $department = $model->update($data);

            $model->clearMediaCollection(Department::DEPARTMENT_THUMBNAIL_COLLECTION);

            if (isset($data['department_thumbnail']) && $data['department_thumbnail']) {
                $file = json_decode($data['department_thumbnail'], true);
                $model->addMediaFromBase64($file['data'])
                    ->usingFileName($file['name'])
                    ->toMediaCollection(Department::DEPARTMENT_THUMBNAIL_COLLECTION);
            }

            DB::commit();

            return $department;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
