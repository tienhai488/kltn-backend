<?php

namespace App\Repositories\Volunteer;

use App\Enum\PriceRangeFilter;
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
        $search = Arr::get($searchParams, 'search', '');
        $keyword = Arr::get($searchParams, 'keyword', '');
        $userId = Arr::get($searchParams, 'user_id', null);
        $belongToUserId = Arr::get($searchParams, 'belong_to_user_id', null);
        $projectId = Arr::get($searchParams, 'project_id', null);
        $departmentId = Arr::get($searchParams, 'department_id', null);
        $status = Arr::get($searchParams, 'status', null);
        $projectsBelongToUserId = Arr::get($searchParams, 'projects_belong_to_user_id', null);
        $isStudent = Arr::get($searchParams, 'is_student', null);
        $projectBelongToUserId = Arr::get($searchParams, 'project_belong_to_user_id', null);

        $query = $this->model->query()->with([
            'user',
            'user.media',
            'user.roles',
            'project',
            'project.media',
            'department',
            'department.media',
        ]);

        if ($search) {
            if (is_array($search)) {
                $search = $search['value'];
            }

            $query->whereAny([
                'name',
                'email',
                'phone_number',
                'student_code',
                'class',
            ], 'LIKE', '%' . $search . '%');
        }

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereAny([
                'name',
            ], 'LIKE', '%' . $keyword . '%');
        }

        if (! is_null($userId)) {
            $query->where('user_id', $userId);
        }

        if (! is_null($belongToUserId)) {
            $query->where('user_id', $belongToUserId);
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

        if (! is_null($projectsBelongToUserId)) {
            $query->whereHas('project', function ($query) use ($projectsBelongToUserId) {
                $query->where('user_id', $projectsBelongToUserId);
            });
        }

        if (! is_null($isStudent)) {
            $query->whereNotNull('student_code')->whereNot('student_code', '');
        }

        if (! is_null($projectBelongToUserId)) {
            $query->whereHas('project', function ($query) use ($projectBelongToUserId) {
                $query->where('user_id', $projectBelongToUserId);
            });
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function serverPaginationFilteringForStatistic($searchParams): LengthAwarePaginator
    {
        $limit = Arr::get($searchParams, 'limit', self::ITEM_PER_PAGE);

        $query = $this->filterForStatistic($searchParams);

        return $query->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function filterForStatistic(array $searchParams): Builder|Volunteer
    {
        $keyword = Arr::get($searchParams, 'search', '');
        $userId = Arr::get($searchParams, 'user_id', null);
        $belongToUserId = Arr::get($searchParams, 'belong_to_user_id', null);
        $projectCategoryId = Arr::get($searchParams, 'project_category_id', null);
        $projectId = Arr::get($searchParams, 'project_id', null);
        $projectType = Arr::get($searchParams, 'project_type', null);
        $projectStatus = Arr::get($searchParams, 'project_status', null);
        $donationVolunteerUserId = Arr::get($searchParams, 'donation_volunteer_user_id', null);
        $donationStatus = Arr::get($searchParams, 'donation_status', null);
        $volunteerStatus = Arr::get($searchParams, 'volunteer_status', null);
        $volunteerWithoutStatus = Arr::get($searchParams, 'volunteer_without_status', null);
        $fromDate = Arr::get($searchParams, 'from_date', null);
        $toDate = Arr::get($searchParams, 'to_date', null);
        $donationPriceRange = Arr::get($searchParams, 'donation_price_range', null);

        $query = $this->model->query()->with([
            'user',
            'user.media',
            'user.roles',
            'project',
            'project.media',
            'department',
            'department.media',
        ]);

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereHas('project', function ($query) use ($keyword) {
                $query->whereAny([
                    'name',
                ], 'LIKE', '%' . $keyword . '%');
            });
        }

        if (! is_null($userId)) {
            $query->whereHas('project', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            });
        }

        if (! is_null($belongToUserId)) {
            $query->where('user_id', $belongToUserId);
        }

        if (! is_null($projectCategoryId)) {
            $query->whereHas('project', function ($query) use ($projectCategoryId) {
                $query->where('category_id', $projectCategoryId);
            });
        }

        if (! is_null($projectId)) {
            $query->where('project_id', $projectId);
        }

        if (! is_null($projectType)) {
            $query->whereHas('project', function ($query) use ($projectType) {
                $query->where('type', $projectType);
            });
        }

        if (! is_null($projectStatus)) {
            $query->whereHas('project', function ($query) use ($projectStatus) {
                $query->where('status', $projectStatus);
            });
        }

        if (! is_null($donationVolunteerUserId)) {
            $query->where('user_id', $donationVolunteerUserId);
        }

        if (! is_null($donationStatus)) {
            $query->whereHas('project', function ($query) use ($donationStatus) {
                $query->whereHas('donations', function ($q) use ($donationStatus) {
                    $q->where('status', $donationStatus);
                });
            });
        }

        if (! is_null($volunteerStatus)) {
            $query->where('status', $volunteerStatus);
        }

        if (! is_null($volunteerWithoutStatus)) {
            $query->where('status', '!=', $volunteerWithoutStatus);
        }

        if (! is_null($fromDate)) {
            $query
                ->whereDate('created_at', '>=', $fromDate)
                ->whereHas('project', function ($q) use ($fromDate) {
                    $q
                        ->whereDate('created_at', '>=', $fromDate)
                        ->whereHas('donations', function ($q) use ($fromDate) {
                            $q->whereDate('created_at', '>=', $fromDate);
                        });
                });
        }

        if (! is_null($toDate)) {
            $query
                ->whereDate('created_at', '<=', $toDate)
                ->whereHas('project', function ($q) use ($toDate) {
                    $q
                        ->whereDate('created_at', '<=', $toDate)
                        ->whereHas('donations', function ($q) use ($toDate) {
                            $q->whereDate('created_at', '<=', $toDate);
                        });
                });
        }

        if (! is_null($donationPriceRange)) {
            $query->whereHas('project', function ($query) use ($donationPriceRange) {
                $query->whereHas('donations', function ($q) use ($donationPriceRange) {
                    $q->where('amount', PriceRangeFilter::getValues($donationPriceRange));
                });
            });
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getVolunteerData(array $conditions)
    {
        return $this->filterForStatistic($conditions)->get();
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