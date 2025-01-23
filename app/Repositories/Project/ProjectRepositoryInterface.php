<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * The repository interface for the Project Model
 */
interface ProjectRepositoryInterface extends RepositoryInterface
{
    /**
     * Paginating, ordering and searching through pages for server side index table for the Admin.
     *
     * @param $searchParams
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringForAdmin(array $searchParams): LengthAwarePaginator;

    /**
     * Update the status of the project.
     *
     * @param Project $project
     * @param int $status
     * @return Project|bool
     */
    public function updateStatus(Project $project, $status): Project|bool;
}