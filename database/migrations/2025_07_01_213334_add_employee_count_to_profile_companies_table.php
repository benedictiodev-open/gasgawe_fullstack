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
        if (!Schema::hasColumn('user_profile_companies', 'employee_count')) {
            Schema::table('user_profile_companies', function (Blueprint $table) {
                $table->after('bio', function (Blueprint $table) {
                    $table->unsignedInteger('employee_count')->nullable();
                });
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('user_profile_companies', 'employee_count')) {
            Schema::table('user_profile_companies', function (Blueprint $table) {
                $table->dropColumn('employee_count')->nullable();
            });
        }
    }
};
