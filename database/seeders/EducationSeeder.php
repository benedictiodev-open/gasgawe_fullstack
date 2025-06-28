<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Education;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educations = [
            [
                'name' => 'SMA/SMK',
                'description' => 'High School or Vocational High School',
                'is_active' => true
            ],
            [
                'name' => 'Diploma (D1-D3)',
                'description' => 'Diploma level education (D1, D2, D3)',
                'is_active' => true
            ],
            [
                'name' => 'Sarjana (S1)',
                'description' => 'Bachelor degree (S1)',
                'is_active' => true
            ],
            [
                'name' => 'Magister (S2)',
                'description' => 'Master degree (S2)',
                'is_active' => true
            ],
            [
                'name' => 'Doctor (S3)',
                'description' => 'Doctorate degree (S3)',
                'is_active' => true
            ]
        ];

        foreach ($educations as $education) {
            Education::create($education);
        }
    }
}
