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
        Schema::create('user_profile_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('company_name')->nullable();
            $table->date('established_date')->nullable();
            $table->foreignId('province_id')->constrained('indonesia_provinces')->nullable();
            $table->foreignId('city_id')->constrained('indonesia_cities')->nullable();
            $table->text('bio')->nullable();
            $table->text('file_profile_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profile_companies');
    }
};
