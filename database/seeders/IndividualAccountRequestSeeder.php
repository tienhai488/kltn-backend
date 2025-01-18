<?php

namespace Database\Seeders;

use App\Models\IndividualAccountRequest;
use Illuminate\Database\Seeder;

class IndividualAccountRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (IndividualAccountRequest::count()) {
            return;
        }

        IndividualAccountRequest::factory(10)->create();
    }
}
