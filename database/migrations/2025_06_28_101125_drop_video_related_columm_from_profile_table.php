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
        Schema::table('user_profile_applicants', function (Blueprint $table) {
            $table->dropColumn('file_profile_video');
        });
        Schema::table('user_profile_companies', function (Blueprint $table) {
            $table->dropColumn('file_profile_video');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profile_applicants', function (Blueprint $table) {
            $table->text('file_profile_video')->nullable();
        });
        Schema::table('user_profile_companies', function (Blueprint $table) {
            $table->text('file_profile_video')->nullable();
        });
    }
};
