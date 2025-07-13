<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string("name", 255);
            $table->enum("role", ["applicant", "recruiter"]);
            $table->integer("total_questions")->default(0);
            $table->integer("estimated_duration")->default(0);
            $table->string("scoring_system", 255);
            $table->timestamps();
        });

        Schema::create('assessment_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments');
            $table->string("name", 255);
            $table->integer("weight")->default(0);
            $table->string("description", 255);
            $table->timestamps();
        });

        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_category_id')->constrained('assessment_categories');
            $table->string("text", 255);
            $table->string("question_type", 255);
            $table->timestamps();
        });

        Schema::create('assessment_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_question_id')->constrained('assessment_questions');
            $table->string("text", 255);
            $table->integer("score_value")->default(0);
            $table->integer("score_conversion")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_options');
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('assessment_categories');
        Schema::dropIfExists('assessments');
    }
};
