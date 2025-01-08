<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * The repository interface for the User Model
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Paginating, ordering and searching through pages for server side index table for the Admin.
     *
     * @param $searchParams
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringForAdmin(array $searchParams): LengthAwarePaginator;

    /**
     * Update password for user.
     *
     * @param \App\Models\User $model
     * @param mixed $data
     */
    public function updatePassword(User $model, $data);
}