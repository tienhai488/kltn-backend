<?php

namespace App\Repositories\Donation;

use App\Enum\PaymentStatus;
use App\Enum\PriceRangeFilter;
use App\Models\Donation;
use App\Models\Project;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
        $search = Arr::get($searchParams, 'search', '');
        $keyword = Arr::get($searchParams, 'keyword', '');
        $userId = Arr::get($searchParams, 'user_id', null);
        $projectId = Arr::get($searchParams, 'project_id', null);
        $departmentId = Arr::get($searchParams, 'department_id', null);
        $isAnonymous = Arr::get($searchParams, 'is_anonymous', null);
        $userId = Arr::get($searchParams, 'user_id', null);
        $projectsBelongToUserId = Arr::get($searchParams, 'projects_belong_to_user_id', null);
        $isStudent = Arr::get($searchParams, 'is_student', null);
        $status = Arr::get($searchParams, 'status', null);
        $projectBelongToUserId = Arr::get($searchParams, 'project_belong_to_user_id', null);

        $query = $this->model->query()->with([
            'user',
            'user.roles',
            'project',
            'department',
        ]);

        if ($search) {
            if (is_array($search)) {
                $search = $search['value'];
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

        if (! is_null($projectId)) {
            $query->where('project_id', $projectId);
        }

        if (! is_null($departmentId)) {
            $query->where('department_id', $departmentId);
        }

        if (! is_null($isAnonymous)) {
            $query->where('is_anonymous', $isAnonymous);
        }

        if (! is_null($projectsBelongToUserId)) {
            $query->whereHas('project', function ($query) use ($projectsBelongToUserId) {
                $query->where('user_id', $projectsBelongToUserId);
            });
        }

        if (! is_null($isStudent)) {
            $query->whereNotNull('student_code')->whereNot('student_code', '');
        }

        if (! is_null($status)) {
            $query->where('status', $status);
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
    public function filterForStatistic(array $searchParams): Builder|Donation
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
        $fromDate = Arr::get($searchParams, 'from_date', null);
        $toDate = Arr::get($searchParams, 'to_date', null);
        $donationPriceRange = Arr::get($searchParams, 'donation_price_range', null);

        $query = $this->model->query()->with([
            'user',
            'user.roles',
            'project',
            'department',
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
            $query->where('status', $donationStatus);
        }

        if (! is_null($volunteerStatus)) {
            $query->whereHas('project', function ($q) use ($volunteerStatus) {
                $q->whereHas('volunteers', function ($q) use ($volunteerStatus) {
                    $q->where('status', $volunteerStatus);
                });
            });
        }

        if (! is_null($fromDate)) {
            $query
                ->whereDate('created_at', '>=', $fromDate)
                ->whereHas('project', function ($q) use ($fromDate) {
                    $q
                        ->whereDate('created_at', '>=', $fromDate)
                        ->whereHas('volunteers', function ($q) use ($fromDate) {
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
                        ->whereHas('volunteers', function ($q) use ($toDate) {
                            $q->whereDate('created_at', '<=', $toDate);
                        });
                });
        }

        if (! is_null($donationPriceRange)) {
            $query->whereBetween('amount', PriceRangeFilter::getValues($donationPriceRange));
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getDonationData(array $conditions)
    {
        return $this->filterForStatistic($conditions)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function serverPaginationFilteringForApi($searchParams): LengthAwarePaginator
    {
        $limit = Arr::get($searchParams, 'limit', self::ITEM_PER_PAGE);

        $query = $this->donationFilterForApi($searchParams);

        return $query->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function donationFilterForApi(array $searchParams): Builder|Donation
    {
        $search = Arr::get($searchParams, 'search', '');
        $keyword = Arr::get($searchParams, 'keyword', '');
        $userId = Arr::get($searchParams, 'user_id', null);
        $projectId = Arr::get($searchParams, 'project_id', null);
        $departmentId = Arr::get($searchParams, 'department_id', null);
        $isAnonymous = Arr::get($searchParams, 'is_anonymous', null);
        $userId = Arr::get($searchParams, 'user_id', null);
        $projectsBelongToUserId = Arr::get($searchParams, 'projects_belong_to_user_id', null);
        $isStudent = Arr::get($searchParams, 'is_student', null);
        $status = Arr::get($searchParams, 'status', null);
        $projectBelongToUserId = Arr::get($searchParams, 'project_belong_to_user_id', null);

        $query = $this->model->query()->with([
            'user',
            'user.roles',
            'user.projects',
            'user.projects.donations_with_paid',
            'user.projects.volunteers_without_canceled',
            'user.roles',
            'project',
            'department',
        ]);

        if ($search) {
            if (is_array($search)) {
                $search = $search['value'];
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

        if (! is_null($projectId)) {
            $query->where('project_id', $projectId);
        }

        if (! is_null($departmentId)) {
            $query->where('department_id', $departmentId);
        }

        if (! is_null($isAnonymous)) {
            $query->where('is_anonymous', $isAnonymous);
        }

        if (! is_null($projectsBelongToUserId)) {
            $query->whereHas('project', function ($query) use ($projectsBelongToUserId) {
                $query->where('user_id', $projectsBelongToUserId);
            });
        }

        if (! is_null($isStudent)) {
            $query->whereNotNull('student_code')->whereNot('student_code', '');
        }

        if (! is_null($status)) {
            $query->where('status', $status);
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
    public function create($data)
    {
        try {
            DB::beginTransaction();

            $model = $this->model->create($data);

            DB::commit();

            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function sumAmount()
    {
        return $this->model
            ->where('status', PaymentStatus::PAID->value)
            ->sum('amount');
    }

    /**
     * {@inheritdoc}
     */
    public function count($status = null): int
    {
        if (is_null($status)) {
            return $this->model->count();
        }
        return $this->model->where('status', $status)->count();
    }

    /**
     * {@inheritdoc}
     */
    public function getChartDonationData(
        array $range,
        $projectId = null,
    ): array {
        $startDate = Carbon::createFromFormat('d/m/Y', $range[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', end($range))->endOfDay();

        $query = $this->model->selectRaw('DATE_FORMAT(created_at, "%d/%m/%Y") as date, sum(amount) as sum_amount')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', PaymentStatus::PAID->value);

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        return $query
            ->groupBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getChartDonationKpiData(Project $project)
    {
        $startDate = Carbon::parse($project->start_date)->startOfDay();
        $endDate = Carbon::parse($project->end_date)->endOfDay();

        $donations = $this->model
            ->selectRaw('DATE_FORMAT(created_at, "%d/%m/%Y") as date, SUM(amount) as sum_amount')
            ->where('project_id', $project->id)
            ->whereBetween('created_at', [$project->start_date, $project->end_date])
            ->whereIn('status', [PaymentStatus::PAID->value])
            ->groupBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        $sumAmount = 0;

        $allDates = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if ($date->gt(Carbon::now())) {
                break;
            }

            $formattedDate = $date->format('d/m/Y');
            $sumAmount += $donations[$formattedDate]['sum_amount'] ?? 0;
            $allDates[$formattedDate] = [
                'date' => $formattedDate,
                'sumAmount' => $sumAmount,
            ];
        }

        return array_values($allDates);
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalAmountByProject(Project $project)
    {
        return $this->model
            ->where('project_id', $project->id)
            ->where('status', PaymentStatus::PAID->value)
            ->whereBetween('created_at', [$project->start_date, $project->end_date])
            ->sum('amount');
    }
}
