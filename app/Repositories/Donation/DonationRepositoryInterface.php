<?php

namespace App\Repositories\Donation;

use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * The repository interface for the Donation Model
 */
interface DonationRepositoryInterface extends RepositoryInterface
{
    /**
     * Paginating, ordering and searching through pages for server side index table for the Admin.
     *
     * @param $searchParams
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringForAdmin(array $searchParams): LengthAwarePaginator;
}