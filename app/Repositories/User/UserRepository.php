<?php

namespace App\Repositories\User;

use App\Acl\Acl;
use App\Enum\UserAvatar;
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
     * Generate a unique username based on the given email.
     *
     * @param string $email
     * @return string
     */
    public function generateUsername($email): string
    {
        $username = explode('@', $email)[0];

        while ($this->model->where('username', $username)->exists()) {
            $username = $username . rand(1, 100);
        }

        return $username;
    }

    /**
     * {@inheritdoc}
     */
    public function create($data)
    {
        try {
            DB::beginTransaction();

            if (empty($data['username'])) {
                $data['username'] = $this->generateUsername($data['email']);
            }

            $user = $this->model->create($data);

            if (isset($data['user_avatar']) && $data['user_avatar']) {
                $file = json_decode($data['user_avatar'], true);
                $user->addMediaFromBase64($file['data'])
                    ->usingFileName($file['name'])
                    ->toMediaCollection(UserAvatar::COLLECTION->value);
            }

            if (! $user->syncRoles(Arr::map($data['roles'], fn($role) => (int) $role))) {
                DB::rollBack();
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

            if (empty($data['username'])) {
                $data['username'] = explode('@', $data['email'])[0];
            }

            while ($this->model->where('username', $data['username'])->exists()) {
                $data['username'] = $data['username'] . rand(1, 100);
            }

            $user = $model->update($data);

            $model->clearMediaCollection(UserAvatar::COLLECTION->value);

            if (isset($data['user_avatar']) && $data['user_avatar']) {
                $file = json_decode($data['user_avatar'], true);
                $model->addMediaFromBase64($file['data'])
                    ->usingFileName($file['name'])
                    ->toMediaCollection(UserAvatar::COLLECTION->value);
            }

            if (isset($data['roles']) && checkPermission(Acl::PERMISSION_ASSIGNEE)) {
                if (! $model->syncRoles(Arr::map($data['roles'], fn($role) => (int) $role))) {
                    DB::rollBack();
                }
            }

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

            $user = $model->update($data);

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
    public function register($data)
    {
        try {
            DB::beginTransaction();

            if (empty($data['username'])) {
                $data['username'] = $this->generateUsername($data['email']);
            }

            $user = $this->model->create($data);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }
}