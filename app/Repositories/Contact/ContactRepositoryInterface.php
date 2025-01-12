<?php

namespace App\Repositories\Contact;

use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * The repository interface for the Contact Model
 */
interface ContactRepositoryInterface extends RepositoryInterface
{
    /**
     * Paginating, ordering and searching through pages for server side index table for the Admin.
     *
     * @param $searchParams
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringForAdmin(array $searchParams): LengthAwarePaginator;

    /**
     * Update status of multiple contacts.
     *
     * @param mixed $data
     * @return bool
     */
    public function updateMultiple($data): bool;
}