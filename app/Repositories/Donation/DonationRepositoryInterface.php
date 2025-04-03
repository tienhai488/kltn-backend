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

    /**
     * Paginating, ordering and searching through pages for server side index table for the Statistic.
     *
     * @param $searchParams
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringForStatistic(array $searchParams): LengthAwarePaginator;

    /**
     * Get all donations according to the given conditions.
     *
     * @param array $conditions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDonationData(array $conditions);

    /**
     * Calculate the total amount of all donations.
     */
    public function sumAmount();
}