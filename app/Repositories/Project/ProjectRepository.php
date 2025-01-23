<?php

namespace App\Repositories\Project;

use App\Enum\VolunteerStatus;
use App\Models\Project;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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

        $query = $this->projectFilter($searchParams);

        return $query->latest()->paginate($limit);
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

            if (isset($data['related_images']) && $data['related_images']) {
                foreach ($data['related_images'] as $file) {
                    if (!empty($file) && !is_null($file[0])) {
                        $fileDecode = json_decode($file['data'], true);
                        $project->addMediaFromBase64($fileDecode['data'])
                            ->usingFileName($fileDecode['name'])
                            ->toMediaCollection(Project::PROJECT_RELATED_IMAGES);
                    }
                }
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
            if (isset($data['related_images']) && $data['related_images']) {
                foreach ($data['related_images'] as $file) {
                    if (!empty($file) && !is_null($file[0])) {
                        $fileDecode = json_decode($file[0], true);
                        $model->addMediaFromBase64($fileDecode['data'])
                            ->usingFileName($fileDecode['name'])
                            ->toMediaCollection(Project::PROJECT_RELATED_IMAGES);
                    }
                }
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
