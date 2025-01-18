<?php

namespace App\Repositories\Role;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * The repository interface for the Role Model
 */
interface RoleRepositoryInterface extends RepositoryInterface
{

    /**
     * Return all roles with loaded permissions
     *
     * @return collection
     */
    public function allRolesWithPermissions();

    /**
     * Get role by name
     *
     * @param string $name
     * @return collection
     */
    public function getRoleByName(string $name): Collection;
}
