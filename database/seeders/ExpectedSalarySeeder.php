<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpectedSalary;

class ExpectedSalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expectedSalaries = [
            [
                'name' => '< Rp. 3.000.000',
                'description' => 'Salary below 3 million rupiah',
                'is_active' => true
            ],
            [
                'name' => 'Rp. 3.000.000 - Rp. 5.000.000',
                'description' => 'Salary between 3 to 5 million rupiah',
                'is_active' => true
            ],
            [
                'name' => 'Rp. 5.000.000 - Rp. 7.000.000',
                'description' => 'Salary between 5 to 7 million rupiah',
                'is_active' => true
            ],
            [
                'name' => 'Rp. 7.000.000 - Rp. 10.000.000',
                'description' => 'Salary between 7 to 10 million rupiah',
                'is_active' => true
            ],
            [
                'name' => 'Rp. 10.000.000 - Rp. 15.000.000',
                'description' => 'Salary between 10 to 15 million rupiah',
                'is_active' => true
            ],
            [
                'name' => '> Rp. 15.000.000',
                'description' => 'Salary above 15 million rupiah',
                'is_active' => true
            ],
            [
                'name' => 'Negotiable',
                'description' => 'Salary is negotiable',
                'is_active' => true
            ]
        ];

        foreach ($expectedSalaries as $salary) {
            ExpectedSalary::create($salary);
        }
    }
}
