<?php

namespace App\Repositories\Volunteer;

use App\Models\Project;
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

    /**
     * Paginating, ordering and searching through pages for server side index table for the Statistic.
     *
     * @param $searchParams
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringForStatistic(array $searchParams): LengthAwarePaginator;

    /**
     * Paginating, ordering and searching through pages for server side index table for the Api.
     *
     * @param $searchParams
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringForApi(array $searchParams): LengthAwarePaginator;

    /**
     * Get data for volunteers filter by conditions
     *
     * @param array $conditions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVolunteerData(array $conditions);

    public function getChartVolunteerData(
        array $range,
        $projectId = null,
    ): array;

    /**
     * Get chart volunteer kpi data by project
     *
     * @param Project $project
     * @return array
     */
    public function getChartVolunteerKpiData(Project $project);

    /**
     * Get count of volunteers by project.
     *
     * @param \App\Models\Project $project
     * @return int
     */
    public function getCountByProject(Project $project);
}
