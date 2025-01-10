<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Department::count()) {
            return;
        }

        $data = [
            [
                'code' => 'D01',
                'name' => 'Phòng ban 1',
                'description' => 'Phòng ban 1',
                'created_at' => now(),
            ],
            [
                'code' => 'D02',
                'name' => 'Phòng ban 2',
                'description' => 'Phòng ban 2',
                'created_at' => now(),
            ],
            [
                'code' => 'D03',
                'name' => 'Phòng ban 3',
                'description' => 'Phòng ban 3',
                'created_at' => now(),
            ],
            [
                'code' => 'D04',
                'name' => 'Phòng ban 4',
                'description' => 'Phòng ban 4',
                'created_at' => now(),
            ],
            [
                'code' => 'D05',
                'name' => 'Phòng ban 5',
                'description' => 'Phòng ban 5',
                'created_at' => now(),
            ],
        ];

        Department::insert($data);
    }
}
