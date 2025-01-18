<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(OrganizationAccountRequestSeeder::class);
        $this->call(IndividualAccountRequestSeeder::class);
    }
}