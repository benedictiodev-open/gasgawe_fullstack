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
        Schema::create('user_experience_skill_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experience_id')->constrained('user_experience_applicants');
            $table->foreignId('skill_id')->constrained('skills');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_experience_skill_applicants');
    }
};
