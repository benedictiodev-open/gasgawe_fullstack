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
        if (!Schema::hasColumn('skills', 'created_at')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('skills', 'created_at')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->dropColumn('created_at');
                $table->dropColumn('updated_at');
                $table->dropColumn('deleted_at');
            });
        }
    }
};
