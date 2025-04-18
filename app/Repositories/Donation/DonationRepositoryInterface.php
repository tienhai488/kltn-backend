<?php

namespace App\Repositories\Donation;

use App\Models\Project;
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
     * Paginating, ordering and searching through pages for server side index table for the API.
     *
     * @param $searchParams
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringForApi(array $searchParams): LengthAwarePaginator;

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

    /**
     * Get chart donation data by range date
     *
     * @param array $range
     * @param int|null $projectId
     * @return array
     */
    public function getChartDonationData(
        array $range,
        $projectId = null,
    ): array;

    /**
     * Get chart donation kpi data by project
     *
     * @param Project $project
     * @return array
     */
    public function getChartDonationKpiData(Project $project);

    /**
     * Get total amount of donations by project
     *
     * @param Project $project
     * @return int
     */
    public function getTotalAmountByProject(Project $project);
}
