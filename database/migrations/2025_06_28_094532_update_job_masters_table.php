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
        Schema::table('job_masters', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->text('description')->nullable()->change();
            $table->dropColumn('min_experience');
            $table->dropColumn('max_experience');
            $table->dropColumn('post_by');
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->foreignId('province_id')->constrained('indonesia_provinces')->nullable();
            $table->foreignId('city_id')->constrained('indonesia_cities')->nullable();
            $table->dropColumn('deadline');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('employment_type_id')->constrained('employment_types');
            $table->dropColumn('job_type');
            $table->dropColumn('min_salary');
            $table->dropColumn('max_salary');
            $table->foreignId('experience_id')->constrained('experiences');
            $table->foreignId('education_id')->constrained('educations');
            $table->foreignId('expected_salary_id')->constrained('expected_salaries');
            $table->text('qualification')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_masters', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('description')->nullable(false)->change();
            $table->integer('min_experience')->nullable();
            $table->integer('max_experience')->nullable();
            $table->string('post_by')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->dropForeign(['province_id']);
            $table->dropForeign(['city_id']);
            $table->dropColumn('province_id');
            $table->dropColumn('city_id');
            $table->date('deadline')->nullable();
            $table->dropColumn('status');
            $table->dropColumn('employment_type');
            $table->dropColumn('education');
            $table->dropColumn('experience');
            $table->dropColumn('expected_salary');
            $table->enum('job_type', ['Fulltime', 'Parttime', 'Freelance', 'Internship', 'Seasonal']);
            $table->integer('min_salary')->nullable();
            $table->integer('max_salary')->nullable();
            $table->softDeletes();
        });
    }
};
