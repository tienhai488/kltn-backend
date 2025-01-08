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
                'email' => 'superadmin@kltn.vn',
                'password' => Hash::make('123456'),
                'status' => UserStatus::ACTIVE->value,
            ]);
        });

        $admin = User::withoutEvents(function () {
            return User::create([
                'name' => 'Admin',
                'email' => 'admin@kltn.vn',
                'password' => Hash::make('123456'),
                'status' => UserStatus::ACTIVE->value,
            ]);
        });

        $superAdminRole = Role::findByName(Acl::ROLE_SUPER_ADMIN);
        $adminRole = Role::findByName(Acl::ROLE_ADMIN);

        //Sync Roles to seed accounts
        $superAdmin->syncRoles($superAdminRole);
        $admin->syncRoles($adminRole);
    }
}