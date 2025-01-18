<?php

namespace Database\Seeders;

use App\Acl\Acl;
use App\Enum\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() > 0) {
            return;
        }

        $superAdmin = User::withoutEvents(function () {
            return User::create([
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@kltn.vn',
                'password' => Hash::make('123456'),
                'status' => UserStatus::ACTIVE->value,
            ]);
        });

        $admin = User::withoutEvents(function () {
            return User::create([
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@kltn.vn',
                'password' => Hash::make('123456'),
                'status' => UserStatus::ACTIVE->value,
            ]);
        });

        $individual = User::withoutEvents(function () {
            return User::create([
                'name' => 'Individual',
                'username' => 'individual',
                'email' => 'individual@kltn.vn',
                'password' => Hash::make('123456'),
                'status' => UserStatus::ACTIVE->value,
            ]);
        });

        $organization = User::withoutEvents(function () {
            return User::create([
                'name' => 'Organization',
                'username' => 'organization',
                'email' => 'organization@kltn.vn',
                'password' => Hash::make('123456'),
                'status' => UserStatus::ACTIVE->value,
            ]);
        });

        $superAdminRole = Role::findByName(Acl::ROLE_SUPER_ADMIN);
        $adminRole = Role::findByName(Acl::ROLE_ADMIN);
        $individualRole = Role::findByName(Acl::ROLE_INDIVIDUAL);
        $organizationRole = Role::findByName(Acl::ROLE_ORGANIZATION);

        //Sync Roles to seed accounts
        $superAdmin->syncRoles($superAdminRole);
        $admin->syncRoles($adminRole);
        $individual->syncRoles($individualRole);
        $organization->syncRoles($organizationRole);
    }
}
