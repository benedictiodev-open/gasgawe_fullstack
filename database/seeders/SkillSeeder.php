<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skillGroup = json_decode(file_get_contents(
            database_path('seeders/json/skill_groups.json')
        ), true);

        $skill = json_decode(file_get_contents(
            database_path('seeders/json/skills.json')
        ), true);

        DB::table('skill_groups')->insert($skillGroup);
        DB::table('skills')->insert($skill);
    }
}
