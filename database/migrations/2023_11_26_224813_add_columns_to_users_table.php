<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_image')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->integer('basic_salary')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_image');
            $table->dropColumn('phone_number');
            $table->dropColumn('address');
            $table->dropColumn('basic_salary');
            $table->dropColumn('bank_name');
            $table->dropColumn('account_number');
        });
    }

}