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
        Schema::table('salaries', function (Blueprint $table) {
            $table->string('additional_salary_name')->nullable();
            $table->integer('additional_salary')->default(0);
            $table->string('month')->nullable();
            $table->string('year')->default('2023');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->dropColumn('additional_salary_name');
            $table->dropColumn('additional_salary');
            $table->dropColumn('month');
            $table->dropColumn('year');
        });
    }
};