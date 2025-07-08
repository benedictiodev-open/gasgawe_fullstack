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
        if (!Schema::hasColumn('user_profile_companies', 'industry_type_id')) {
            Schema::table('user_profile_companies', function (Blueprint $table) {
                $table->foreignId('industry_type_id')
                    ->nullable()
                    ->default(null)
                    ->constrained('industry_types')
                    ->after('city_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('user_profile_companies', 'industry_type_id')) {
            Schema::table('user_profile_companies', function (Blueprint $table) {
                $table->dropForeign(['industry_type_id']);
            });

            Schema::table('user_profile_companies', function (Blueprint $table) {
                $table->dropColumn('industry_type_id');
            });
        }
    }
};
