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
        if (!Schema::hasColumn('industry_types', 'deleted_at')) {
            Schema::table('industry_types', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('industry_types', 'deleted_at')) {
            Schema::table('industry_types', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
    }
};
