<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Experience;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experiences = [
            [
                'name' => 'Fresh Graduate',
                'description' => 'No work experience, just graduated',
                'is_active' => true
            ],
            [
                'name' => '< 1 Year',
                'description' => 'Less than 1 year of work experience',
                'is_active' => true
            ],
            [
                'name' => '1-3 Year',
                'description' => '1 to 3 years of work experience',
                'is_active' => true
            ],
            [
                'name' => '3-5 Year',
                'description' => '3 to 5 years of work experience',
                'is_active' => true
            ],
            [
                'name' => '5-10 Year',
                'description' => '5 to 10 years of work experience',
                'is_active' => true
            ],
            [
                'name' => '> 10 Year',
                'description' => 'More than 10 years of work experience',
                'is_active' => true
            ]
        ];

        foreach ($experiences as $experience) {
            Experience::create($experience);
        }
    }
}
