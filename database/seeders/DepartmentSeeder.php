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
        $data = [
            [
                'code'        => 'D01',
                'name'        => 'Khoa Công nghệ Thông tin',
                'description' => 'Khoa Công nghệ Thông tin',
            ],
            [
                'code'        => 'D02',
                'name'        => 'Khoa Giáo dục',
                'description' => 'Khoa Giáo dục',
            ],
            [
                'code'        => 'D03',
                'name'        => 'Khoa Giáo dục Chính trị',
                'description' => 'Khoa Giáo dục Chính trị',
            ],
            [
                'code'        => 'D04',
                'name'        => 'Khoa Giáo dục Mầm non',
                'description' => 'Khoa Giáo dục Mầm non',
            ],
            [
                'code'        => 'D05',
                'name'        => 'Khoa Giáo dục quốc phòng - An ninh - Giáo dục thể chất',
                'description' => 'Khoa Giáo dục quốc phòng - An ninh - Giáo dục thể chất',
            ],
            [
                'code'        => 'D06',
                'name'        => 'Khoa Giáo dục Tiểu học',
                'description' => 'Khoa Giáo dục Tiểu học',
            ],
            [
                'code'        => 'D07',
                'name'        => 'Khoa Khoa học Xã hội và Nghệ thuật',
                'description' => 'Khoa Khoa học Xã hội và Nghệ thuật',
            ],
            [
                'code'        => 'D08',
                'name'        => 'Khoa Kỹ thuật và Công nghệ',
                'description' => 'Khoa Kỹ thuật và Công nghệ',
            ],
            [
                'code'        => 'D09',
                'name'        => 'Khoa Luật',
                'description' => 'Khoa Luật',
            ],
            [
                'code'        => 'D10',
                'name'        => 'Khoa Ngoại ngữ',
                'description' => 'Khoa Ngoại ngữ',
            ],
            [
                'code'        => 'D11',
                'name'        => 'Khoa Quản trị Kinh doanh',
                'description' => 'Khoa Quản trị Kinh doanh',
            ],
            [
                'code'        => 'D12',
                'name'        => 'Khoa Sư phạm Khoa học Tự nhiên',
                'description' => 'Khoa Sư phạm Khoa học Tự nhiên',
            ],
            [
                'code'        => 'D13',
                'name'        => 'Khoa Tài chính - Kế toán',
                'description' => 'Khoa Tài chính - Kế toán',
            ],
            [
                'code'        => 'D14',
                'name'        => 'Khoa Toán - Ứng dụng',
                'description' => 'Khoa Toán - Ứng dụng',
            ],
            [
                'code'        => 'D15',
                'name'        => 'Khoa Văn hóa và Du lịch',
                'description' => 'Khoa Văn hóa và Du lịch',
            ],
        ];

        foreach ($data as $item) {
            Department::firstOrCreate(
                ['code' => $item['code']],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                ]
            );
        }
    }
}
