<?php

namespace App\Repositories\Project;

use App\Acl\Acl;
use App\Enum\ProjectStatus;
use App\Enum\UserType;
use App\Models\Project;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
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
        $type = Arr::get($searchParams, 'type', null);
        $categoryId = Arr::get($searchParams, 'category_id', null);
        $role = Arr::get($searchParams, 'role', null);
        $keyword = Arr::get($searchParams, 'keyword', '');
        $projectId = Arr::get($searchParams, 'project_id', null);
        $userId = Arr::get($searchParams, 'user_id', null);
        $userType = Arr::get($searchParams, 'user_type', null);

        $query = $this->model->query()
            ->whereHas('user.roles', function ($q) {
                $q->whereIn('name', [Acl::ROLE_ORGANIZATION, Acl::ROLE_INDIVIDUAL]);
            })
            ->whereIn('status', [ProjectStatus::APPROVED, ProjectStatus::PAUSED])
            ->with('user', 'category')
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

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function create($data)
    {
        try {
            DB::beginTransaction();

            $data['user_id'] = auth()->id();
            $project = $this->model->create($data);

            $backgroundImage = json_decode($data['background_image'], true);
            $project->addMediaFromBase64($backgroundImage['data'])
                ->usingFileName($backgroundImage['name'])
                ->toMediaCollection(Project::PROJECT_BACKGROUND_IMAGE);

            if (!empty($data['images'])) {
                foreach ($data['images'] as $path) {
                    if (!empty($path)) {
                        $fullPath = storage_path('app/public/' . json_decode($path, true));
                        if (file_exists($fullPath)) {
                            $project->addMedia($fullPath)
                                ->usingFileName(uniqid() . '.jpg')
                                ->toMediaCollection(Project::PROJECT_RELATED_IMAGES);
                        }
                    }
                }
                Storage::disk('public')->deleteDirectory('uploads');
            }

            DB::commit();

            return $project;
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

            $model->update($data);

            $model->clearMediaCollection(Project::PROJECT_BACKGROUND_IMAGE);
            $backgroundImage = json_decode($data['background_image'], true);
            $model->addMediaFromBase64($backgroundImage['data'])
                ->usingFileName($backgroundImage['name'])
                ->toMediaCollection(Project::PROJECT_BACKGROUND_IMAGE);

            $model->clearMediaCollection(Project::PROJECT_RELATED_IMAGES);
            if (!empty($data['images'])) {
                foreach ($data['images'] as $path) {
                    if (!empty($path)) {
                        $fullPath = storage_path('app/public/' . json_decode($path, true));
                        if (file_exists($fullPath)) {
                            $model->addMedia($fullPath)
                                ->usingFileName(uniqid() . '.jpg')
                                ->toMediaCollection(Project::PROJECT_RELATED_IMAGES);
                        }
                    }
                }
                Storage::disk('public')->deleteDirectory('uploads');
            }

            DB::commit();

            return $model;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
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
