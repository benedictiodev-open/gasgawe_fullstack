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
            $table->enum('job_type', ['full time', 'part time', 'daily', 'internship', 'freelance'])
                ->default('full time')
                ->nullable()->change();
            $table->integer('min_experience')->nullable();
            $table->integer('max_experience')->nullable();
            $table->string('post_by')->nullable();
            $table->bigInteger('min_salary')->nullable()->change();
            $table->bigInteger('max_salary')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_masters', function (Blueprint $table) {
            $table->dropColumn('min_experience');
            $table->dropColumn('max_experience');
            $table->dropColumn('post_by');
        });
    }
};
