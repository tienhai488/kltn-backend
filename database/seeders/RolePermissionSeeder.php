<?php

namespace Database\Seeders;

use App\Acl\Acl;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (Acl::roles() as $role) {
            Role::findOrCreate($role);
        }

        foreach (Acl::permissions() as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $superAdminRole = Role::findByName(Acl::ROLE_SUPER_ADMIN);
        $adminRole = Role::findByName(Acl::ROLE_ADMIN);
        $individualRole = Role::findByName(Acl::ROLE_INDIVIDUAL);
        $organizationRole = Role::findByName(Acl::ROLE_ORGANIZATION);

        $superAdminRole->givePermissionTo(Acl::permissions());
        $adminRole->givePermissionTo(Acl::permissions([Acl::PERMISSION_ROLE_LIST]));
        $individualRole->givePermissionTo([]);
        $organizationRole->givePermissionTo([]);
    }
}