<?php

namespace App\Repositories\Volunteer;

use App\Models\Volunteer;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * The repository for Volunteer Model
 */
class VolunteerRepository extends BaseRepository implements VolunteerRepositoryInterface
{
    const ITEM_PER_PAGE = 50;

    /**
     * {@inheritdoc}
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(Volunteer $model)
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

        $query = $this->volunteerFilter($searchParams);

        return $query->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function volunteerFilter(array $searchParams): Builder|Volunteer
    {
        $keyword = Arr::get($searchParams, 'search', '');
        $userId = Arr::get($searchParams, 'user_id', null);
        $projectId = Arr::get($searchParams, 'project_id', null);
        $departmentId = Arr::get($searchParams, 'department_id', null);
        $status = Arr::get($searchParams, 'status', null);

        $query = $this->model->query()->with(['user', 'project', 'department']);

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereAny([
                'name',
                'email',
                'phone_number',
                'student_code',
                'class',
            ], 'LIKE', '%' . $keyword . '%');
        }

        if (! is_null($userId)) {
            $query->where('user_id', $userId);
        }

        if (! is_null($projectId)) {
            $query->where('project_id', $projectId);
        }

        if (! is_null($departmentId)) {
            $query->where('department_id', $departmentId);
        }

        if (! is_null($status)) {
            $query->where('status', $status);
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function update($model, $data)
    {
        try {
            DB::beginTransaction();

            $model->update($data);

            DB::commit();

            return $model;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}