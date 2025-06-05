<?php

namespace App\Repositories\Project;

use App\Acl\Acl;
use App\Enum\PriceRangeFilter;
use App\Enum\ProjectFrontStatus;
use App\Enum\ProjectStatus;
use App\Enum\UserType;
use App\Models\Project;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * The repository for Project Model
 */
class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    const ITEM_PER_PAGE = 50;

    /**
     * {@inheritdoc}
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(Project $model)
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

        return $this->projectFilter($searchParams)->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function projectFilter(array $searchParams): Builder|Project
    {
        $keyword = Arr::get($searchParams, 'search', '');
        $status = Arr::get($searchParams, 'status', null);
        $type = Arr::get($searchParams, 'type', null);
        $userId = Arr::get($searchParams, 'user_id', null);
        $categoryId = Arr::get($searchParams, 'category_id', null);

        $query = $this->model->query()
            ->with('category', 'user', 'donations', 'volunteers')
            ->withCount([
                'volunteers',
                'volunteers_without_canceled',
                'donations',
            ])
            ->withSum('donations', 'amount');

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereAny([
                'name',
                'donation_target',
                'volunteer_quantity',
                'type',
            ], 'LIKE', '%' . $keyword . '%');
        }

        if (! is_null($userId)) {
            $query->where('user_id', $userId);
        }

        if (! is_null($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (! is_null($type)) {
            $query->where('type', $type);
        }

        if (! is_null($status)) {
            $query->where('status', $status);
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function serverPaginationFilteringForApi(array $searchParams): LengthAwarePaginator
    {
        $limit = Arr::get($searchParams, 'limit', self::ITEM_PER_PAGE);

        return $this->apiFilter($searchParams)->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function apiFilter(array $searchParams): Builder|Project
    {
        $keyword = Arr::get($searchParams, 'keyword', '');
        $type = Arr::get($searchParams, 'type', null);
        $categoryId = Arr::get($searchParams, 'category_id', null);
        $role = Arr::get($searchParams, 'role', null);
        $projectId = Arr::get($searchParams, 'project_id', null);
        $userId = Arr::get($searchParams, 'user_id', null);
        $userType = Arr::get($searchParams, 'user_type', null);
        $projectSlug = Arr::get($searchParams, 'project_slug', null);
        $frontStatus = Arr::get($searchParams, 'front_status', null);
        $isProcessing = Arr::get($searchParams, 'is_processing', null);

        $query = $this->model->query()
            ->with(
                'user',
                'user.roles',
                'user.projects',
                'user.projects.donations_with_paid',
                'user.projects.volunteers_without_canceled',
                'category',
                'volunteers_without_canceled',
                'donations_with_paid',
            )
            ->withCount([
                'volunteers_without_canceled',
                'donations_with_paid',
            ])
            ->withSum('donations_with_paid', 'amount')
            ->whereHas('user.roles', function ($q) {
                $q->whereIn('name', [Acl::ROLE_ORGANIZATION, Acl::ROLE_INDIVIDUAL]);
            })
            ->whereIn('status', [ProjectStatus::APPROVED, ProjectStatus::PAUSED]);

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereAny([
                'name',
            ], 'LIKE', '%' . $keyword . '%');
        }

        if (! is_null($role)) {
            $query->whereHas('user.roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        if (! is_null($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (! is_null($type)) {
            $query->where('type', $type);
        }

        if (! is_null($projectId)) {
            $query->where('id', $projectId);
        }

        if (! is_null($userId)) {
            $query->where('user_id', $userId);
        }

        if (! is_null($userType)) {
            if (!$userType != UserType::USER->value) {
                $query->whereHas('user.roles', function ($subQuery) use ($userType) {
                    match ($userType) {
                        UserType::ADMIN->value => $subQuery->whereIn('name', [Acl::ROLE_ADMIN, Acl::ROLE_SUPER_ADMIN]),
                        UserType::ORGANIZATION->value => $subQuery->where('name', Acl::ROLE_ORGANIZATION),
                        UserType::INDIVIDUAL->value => $subQuery->where('name', Acl::ROLE_INDIVIDUAL),
                        default => $subQuery->where('name', $userType),
                    };
                });
            } else {
                $query->whereDoesntHave('user.roles');
            }
        }

        if (! is_null($projectSlug)) {
            $query->where('slug', $projectSlug);
        }

        if (! is_null($frontStatus)) {
            switch ($frontStatus) {
                case ProjectFrontStatus::PAUSED->value:
                    $query->where('status', ProjectStatus::PAUSED->value);
                    break;
                case ProjectFrontStatus::FINISHED->value:
                    $query->where('status', ProjectStatus::APPROVED->value)
                        ->where('end_date', '<', now());
                    break;
                case ProjectFrontStatus::GOAL_ACHIEVED->value:
                    $query->where('status', ProjectStatus::APPROVED->value)
                        ->where('end_date', '>=', now())
                        ->whereHas('donations_with_paid', function ($q) {
                            $q->select(DB::raw('SUM(amount) as total_amount'), 'project_id')
                                ->groupBy('project_id')
                                ->havingRaw('total_amount >= projects.donation_target');
                        })
                        ->whereHas('volunteers_without_canceled', function ($q) {
                            $q->select(DB::raw('COUNT(*) as volunteer_count'), 'project_id')
                                ->groupBy('project_id')
                                ->havingRaw('volunteer_count >= projects.volunteer_quantity');
                        });
                    break;
                case ProjectFrontStatus::IN_PROGRESS->value:
                    $query->where('status', ProjectStatus::APPROVED->value)
                        ->where('end_date', '>=', now())
                        ->where(function ($q) {
                            $q->whereDoesntHave('donations_with_paid', function ($q1) {
                                $q1->select(DB::raw('SUM(amount) as total_amount'), 'project_id')
                                    ->groupBy('project_id')
                                    ->havingRaw('total_amount >= projects.donation_target');
                            })
                                ->orWhereDoesntHave('volunteers_without_canceled', function ($q1) {
                                    $q1->select(DB::raw('COUNT(*) as volunteer_count'), 'project_id')
                                        ->groupBy('project_id')
                                        ->havingRaw('volunteer_count >= projects.volunteer_quantity');
                                });
                        });
                    break;
            }
        }

        if (! is_null($isProcessing)) {
            // where start_date <= now()
            $query->whereDate('start_date', '<=', now());
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function serverPaginationFilteringForStatistic($searchParams): LengthAwarePaginator
    {
        $limit = Arr::get($searchParams, 'limit', self::ITEM_PER_PAGE);

        return $this->filterForStatistic($searchParams)->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function filterForStatistic(array $searchParams): Builder|Project
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

        $query = $this->model->query()
            ->with('category', 'user', 'donations', 'volunteers')
            ->withCount([
                'volunteers',
                'volunteers_without_canceled',
                'donations',
                'donations_with_paid as projects_donations_with_paid_count',
            ])
            ->withSum('donations_with_paid as projects_donations_with_paid_sum_amount', 'amount');

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
            $query
                ->whereHas('donations', function ($q) use ($belongToUserId) {
                    $q->where('user_id', $belongToUserId);
                })
                ->orWhereHas('volunteers', function ($q) use ($belongToUserId) {
                    $q->where('user_id', $belongToUserId);
                });
        }

        if (! is_null($projectCategoryId)) {
            $query->where('category_id', $projectCategoryId);
        }

        if (! is_null($projectId)) {
            $query->where('id', $projectId);
        }

        if (! is_null($projectType)) {
            $query->where('type', $projectType);
        }

        if (! is_null($projectStatus)) {
            $query->where('status', $projectStatus);
        }

        if (! is_null($donationVolunteerUserId)) {
            $query
                ->whereHas('donations', function ($q) use ($donationVolunteerUserId) {
                    $q->where('user_id', $donationVolunteerUserId);
                })
                ->orWhereHas('volunteers', function ($q) use ($donationVolunteerUserId) {
                    $q->where('user_id', $donationVolunteerUserId);
                });
        }

        if (! is_null($donationStatus)) {
            $query->whereHas('donations', function ($q) use ($donationStatus) {
                $q->where('status', $donationStatus);
            });
        }

        if (! is_null($volunteerStatus)) {
            $query->whereHas('volunteers', function ($q) use ($volunteerStatus) {
                $q->where('status', $volunteerStatus);
            });
        }

        if (! is_null($fromDate)) {
            $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->startOfDay();

            $query->whereDate('created_at', '>=', $fromDate)
                ->whereHas('volunteers', function ($q) use ($fromDate) {
                    $q->whereDate('created_at', '>=', $fromDate);
                })
                ->whereHas('donations', function ($q) use ($fromDate) {
                    $q->whereDate('created_at', '>=', $fromDate);
                });
        }

        if (! is_null($toDate)) {
            $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->endOfDay();

            $query->whereDate('created_at', '<=', $toDate)
                ->whereHas('volunteers', function ($q) use ($toDate) {
                    $q->whereDate('created_at', '<=', $toDate);
                })
                ->whereHas('donations', function ($q) use ($toDate) {
                    $q->whereDate('created_at', '<=', $toDate);
                });
        }

        if (! is_null($donationPriceRange)) {
            $query->whereHas('donations', function ($q) use ($donationPriceRange) {
                $q->whereBetween('amount', PriceRangeFilter::getValues($donationPriceRange));
            });
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectData(array $conditions)
    {
        $cacheKey = 'project_data_' . md5(json_encode($conditions));

        $ttlSeconds = 30;

        // return Cache::remember($cacheKey, $ttlSeconds, function () use ($conditions) {
        return $this->filterForStatistic($conditions)->get();
        // });
    }

    /**
     * {@inheritdoc}
     */
    public function create($data)
    {
        // try {
        DB::beginTransaction();

        $data['user_id'] = auth()->id();
        $data['donation_target'] = (int) $data['donation_target'];
        $data['volunteer_quantity'] = (int) $data['volunteer_quantity'];
        $project = $this->model->create($data);

        $backgroundImage = json_decode($data['background_image'], true);
        $project->addMediaFromBase64($backgroundImage['data'])
            ->usingFileName(uniqid('project-') . '.jpg')
            ->toMediaCollection(Project::PROJECT_BACKGROUND_IMAGE);

        if (!empty($data['images'])) {
            foreach ($data['images'] as $path) {
                if (!empty($path)) {
                    $fullPath = storage_path('app/public/' . json_decode($path, true));
                    if (file_exists($fullPath)) {
                        $project->addMedia($fullPath)
                            ->usingFileName(uniqid('project-') . '.jpg')
                            ->toMediaCollection(Project::PROJECT_RELATED_IMAGES);
                    }
                }
            }
            Storage::disk('public')->deleteDirectory('uploads');
        }

        DB::commit();

        return $project;
        // } catch (\Exception $e) {
        //     DB::rollBack();

        //     return $e->getMessage();
        // }
    }

    /**
     * {@inheritdoc}
     */
    public function update($model, $data)
    {
        // try {
        DB::beginTransaction();

        $data['donation_target'] = (int) $data['donation_target'];
        $data['volunteer_quantity'] = (int) $data['volunteer_quantity'];
        $model->update($data);

        $model->clearMediaCollection(Project::PROJECT_BACKGROUND_IMAGE);
        $backgroundImage = json_decode($data['background_image'], true);
        $model->addMediaFromBase64($backgroundImage['data'])
            ->usingFileName(uniqid('project-') . '.jpg')
            ->toMediaCollection(Project::PROJECT_BACKGROUND_IMAGE);

        $model->clearMediaCollection(Project::PROJECT_RELATED_IMAGES);
        if (!empty($data['images'])) {
            foreach ($data['images'] as $path) {
                if (!empty($path)) {
                    $fullPath = storage_path('app/public/' . json_decode($path, true));
                    if (file_exists($fullPath)) {
                        $model->addMedia($fullPath)
                            ->usingFileName(uniqid('project-') . '.jpg')
                            ->toMediaCollection(Project::PROJECT_RELATED_IMAGES);
                    }
                }
            }
            Storage::disk('public')->deleteDirectory('uploads');
        }

        DB::commit();

        return $model;
        // } catch (\Exception $e) {
        //     DB::rollBack();

        //     return false;
        // }
    }

    /**
     * {@inheritdoc}
     */
    public function updateStatus(Project $project, $status): Project|bool
    {
        try {
            DB::beginTransaction();

            $project->update(['status' => $status]);

            DB::commit();

            return $project;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
