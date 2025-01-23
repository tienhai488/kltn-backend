<?php

namespace App\Repositories\Volunteer;

use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * The repository interface for the Volunteer Model
 */
interface VolunteerRepositoryInterface extends RepositoryInterface
{
    /**
     * Paginating, ordering and searching through pages for server side index table for the Admin.
     *
     * @param $searchParams
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringForAdmin(array $searchParams): LengthAwarePaginator;
}