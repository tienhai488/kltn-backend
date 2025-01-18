<?php

namespace Database\Seeders;

use App\Models\OrganizationAccountRequest;
use Illuminate\Database\Seeder;

class OrganizationAccountRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (OrganizationAccountRequest::count()) {
            return;
        }

        OrganizationAccountRequest::factory(10)->create();
    }
}
