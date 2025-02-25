<?php

namespace App\Repositories\Permission;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * The repository interface for the Permission Model
 */
interface PermissionRepositoryInterface extends RepositoryInterface
{
    /**
     * Group permissions by group.
     *
     * @param $permissions
     * @param array $groups
     * @return \Illuminate\Support\Collection
     */
    public function groupPermissions($permissions, $groups): Collection;
}