<?php

namespace App\Repositories\User;

use App\Acl\Acl;
use App\Enum\UserAvatar;
use App\Enum\UserStatus;
use App\Enum\UserType;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * The repository for User Model
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    const ITEM_PER_PAGE = 50;

    /**
     * {@inheritdoc}
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(User $model)
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

        $query = $this->userFilter($searchParams);

        $query->latest();

        return $query->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function userFilter(array $searchParams): Builder|User
    {
        $keyword = Arr::get($searchParams, 'search', '');
        $role = Arr::get($searchParams, 'role', '');
        $status = Arr::get($searchParams, 'status', null);

        $query = $this->model->query()->with('roles');

        if ($role) {
            $query->role($role);
        }

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereAny([
                'name',
                'email',
                'phone_number',
                'id',
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
    public function serverPaginationFilteringForApi($searchParams): LengthAwarePaginator
    {
        $limit = Arr::get($searchParams, 'limit', self::ITEM_PER_PAGE);

        $query = $this->userFilterForApi($searchParams);

        return $query->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function userFilterForApi(array $searchParams): Builder|User
    {
        $keyword = Arr::get($searchParams, 'keyword', '');
        $status = Arr::get($searchParams, 'status', null);
        $departmentId = Arr::get($searchParams, 'department_id', null);
        $type = Arr::get($searchParams, 'type', null);
        $username = Arr::get($searchParams, 'username', null);

        $query = $this->model->query()
            ->with([
                'department',
                'roles',
                'projects.donations_with_paid',
                'projects.volunteers_without_canceled',
            ])
            ->withCount([
                'projects',
                'donations_with_paid',
                'volunteers_without_canceled',
            ])
            ->withSum('donations_with_paid', 'amount');

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereAny([
                'name',
                'username',
                'email',
                'phone_number',
                'id',
            ], 'LIKE', '%' . $keyword . '%');
        }

        if (! is_null($status)) {
            $query->where('status', $status);
        }

        if (! is_null($departmentId)) {
            $query->where('department_id', $departmentId);
        }

        if (! is_null($type)) {
            if (!$type != UserType::USER->value) {
                $query->whereHas('roles', function ($subQuery) use ($type) {
                    match ($type) {
                        UserType::ADMIN->value => $subQuery->whereIn('name', [Acl::ROLE_ADMIN, Acl::ROLE_SUPER_ADMIN]),
                        UserType::ORGANIZATION->value => $subQuery->where('name', Acl::ROLE_ORGANIZATION),
                        UserType::INDIVIDUAL->value => $subQuery->where('name', Acl::ROLE_INDIVIDUAL),
                        default => $subQuery->where('name', $type),
                    };
                });
            } else {
                $query->whereDoesntHave('roles');
            }
        }

        if (! is_null($username)) {
            $query->where('username', $username);
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

            $user = $this->model->create($data);

            if (!empty($data['user_avatar'])) {
                $file = json_decode($data['user_avatar'], true);
                $user->addMediaFromBase64($file['data'])
                    ->usingFileName(uniqid('user-') . '.jpg')
                    ->toMediaCollection(UserAvatar::COLLECTION->value);
            }

            if (!empty($data['role'])) {
                if (!$user->syncRoles([(int)$data['role']])) {
                    DB::rollBack();
                }
            }

            DB::commit();

            return $user;
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

            $user = $model->update($data);

            $model->clearMediaCollection(UserAvatar::COLLECTION->value);
            if (!empty($data['user_avatar'])) {
                $file = json_decode($data['user_avatar'], true);
                $model->addMediaFromBase64($file['data'])
                    ->usingFileName(uniqid('user-') . '.jpg')
                    ->toMediaCollection(UserAvatar::COLLECTION->value);
            }

            if (!empty($data['role'])) {
                if (!$model->syncRoles([(int)$data['role']])) {
                    DB::rollBack();
                }
            } else {
                $model->syncRoles([]);
            }

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateProfile(User $model, array $data)
    {
        try {
            DB::beginTransaction();

            $user = $model->update($data);

            $model->clearMediaCollection(UserAvatar::COLLECTION->value);
            if (!empty($data['user_avatar'])) {
                $file = json_decode($data['user_avatar'], true);
                $model->addMediaFromBase64($file['data'])
                    ->usingFileName(uniqid('user-') . '.jpg')
                    ->toMediaCollection(UserAvatar::COLLECTION->value);
            }

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateProfileForApi(User $model, array $data): bool
    {
        try {
            DB::beginTransaction();

            $user = $model->update($data);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updatePassword(User $model, $data)
    {
        try {
            DB::beginTransaction();

            $model->update($data);

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
    public function register($data)
    {
        try {
            DB::beginTransaction();

            $data['status'] = UserStatus::ACTIVE->value;
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
    public function count(string $role = null): int
    {
        $query = $this->model->query();

        if ($role) {
            $query->whereHas('roles', fn($query) => $query->where('name', $role));
        }

        return $query->count();
    }

    /**
     * {@inheritdoc}
     */
    public function updateAvatar(User $model, $data)
    {
        try {
            DB::beginTransaction();

            $model->clearMediaCollection(User::USER_AVATAR_COLLECTION);
            $model->addMediaFromBase64($data['base64'])
                ->usingFileName(uniqid('user-') . '.jpg')
                ->toMediaCollection(User::USER_AVATAR_COLLECTION);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function toggleStatus($model)
    {
        try {
            DB::beginTransaction();

            $status = $model->status == UserStatus::ACTIVE ? UserStatus::LOCKED : UserStatus::ACTIVE;
            $model->update(['status' => $status]);

            DB::commit();

            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * @inheritdoc
     */
    public function getMembers()
    {
        return $this->model->whereHas('roles', function ($query) {
            $query->whereIn('name', [
                Acl::ROLE_ORGANIZATION,
                Acl::ROLE_INDIVIDUAL,
            ]);
        })->get();
    }

    /**
     * @inheritdoc
     */
    public function getUsers()
    {
        return $this->model->whereDoesntHave('roles')->get();
    }
}
