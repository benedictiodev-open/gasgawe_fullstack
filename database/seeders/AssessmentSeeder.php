<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $this->command->info('Seeding assessments...');

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('assessment_options')->truncate();
            DB::table('assessment_questions')->truncate();
            DB::table('assessment_categories')->truncate();
            DB::table('assessments')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $assessments = json_decode(file_get_contents(
                database_path('seeders/json/assessments.json')
            ), true);

            $assessment_categories = json_decode(file_get_contents(
                database_path('seeders/json/assessment_categories.json')
            ), true);

            $assessment_questions = json_decode(file_get_contents(
                database_path('seeders/json/assessment_questions.json')
            ), true);

            $assessment_options = json_decode(file_get_contents(
                database_path('seeders/json/assessment_options.json')
            ), true);


            foreach ($assessments as $assessment_key => $assessment_value) {
                $assesment = DB::table('assessments')->insertGetId([
                    'name' => $assessment_value['assessment_name'],
                    "role" => $assessment_value['role'],
                    'total_questions' => $assessment_value['total_questions'],
                    'estimated_duration' => $assessment_value['estimated_duration'],
                    'scoring_system' => $assessment_value['scoring_system'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($assessment_categories[$assessment_key] as $category_key => $category_value) {
                    $category = DB::table('assessment_categories')->insertGetId([
                        'assessment_id' => $assesment,
                        'name' => $category_value['name'],
                        'weight' => $category_value['weight'],
                        'description' => $category_value['description'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    foreach ($assessment_questions[$assessment_key][$category_key] as $question_key => $question_value) {
                        $question = DB::table('assessment_questions')->insertGetId([
                            'assessment_category_id' => $category,
                            'text' => $question_value['text'],
                            'question_type' => $question_value['question_type'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        foreach ($assessment_options[$assessment_key][$category_key][$question_key] as $option_key => $option_value) {
                            DB::table('assessment_options')->insert([
                                'assessment_question_id' => $question,
                                'text' => $option_value['text'],
                                'score_value' => $option_value['score_value'],
                                'score_conversion' => $option_value['score_conversion'],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }

            $this->command->info('Seeding assessments completed successfully.');
        } catch (Exception $e) {
            Log::error('Error in AssessmentSeeder: ' . $e->getMessage());
            $this->command->error('Seeding assessments encountered errors.');
            return;
        }
    }
}
