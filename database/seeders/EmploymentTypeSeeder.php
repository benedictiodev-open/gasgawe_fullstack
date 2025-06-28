<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmploymentType;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employmentTypes = [
            [
                'name' => 'Fulltime',
                'description' => 'Full-time employment with regular working hours',
                'is_active' => true
            ],
            [
                'name' => 'Parttime',
                'description' => 'Part-time employment with flexible working hours',
                'is_active' => true
            ],
            [
                'name' => 'Freelance',
                'description' => 'Freelance work on project basis',
                'is_active' => true
            ],
            [
                'name' => 'Internship',
                'description' => 'Internship position for students or fresh graduates',
                'is_active' => true
            ],
            [
                'name' => 'Contract',
                'description' => 'Contract-based employment for specific period',
                'is_active' => true
            ],
            [
                'name' => 'Remote',
                'description' => 'Remote work from anywhere',
                'is_active' => true
            ]
        ];

        foreach ($employmentTypes as $type) {
            EmploymentType::create($type);
        }
    }
}
