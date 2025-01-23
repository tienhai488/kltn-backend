<?php

namespace App\Repositories\Donation;

use App\Models\Donation;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/**
 * The repository for Donation Model
 */
class DonationRepository extends BaseRepository implements DonationRepositoryInterface
{
    const ITEM_PER_PAGE = 50;

    /**
     * {@inheritdoc}
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(Donation $model)
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

        $query = $this->donationFilter($searchParams);

        return $query->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function donationFilter(array $searchParams): Builder|Donation
    {
        $keyword = Arr::get($searchParams, 'search', '');
        $userId = Arr::get($searchParams, 'user_id', null);
        $projectId = Arr::get($searchParams, 'project_id', null);
        $departmentId = Arr::get($searchParams, 'department_id', null);
        $isAnonymous = Arr::get($searchParams, 'is_anonymous', null);

        $query = $this->model->query()->with(['user', 'project', 'department']);

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereAny([
                'account_number',
                'account_name',
                'code',
                'name',
                'email',
                'phone_number',
                'amount',
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

        if (! is_null($isAnonymous)) {
            $query->where('is_anonymous', $isAnonymous);
        }

        return $query;
    }
}
