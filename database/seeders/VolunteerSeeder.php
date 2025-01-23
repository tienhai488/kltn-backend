<?php

namespace Database\Seeders;

use App\Models\Volunteer;
use Illuminate\Database\Seeder;

class VolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Volunteer::count()) {
            return;
        }

        Volunteer::factory(10)->create();
    }
}