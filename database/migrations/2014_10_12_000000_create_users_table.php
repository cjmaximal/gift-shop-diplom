<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->integer('address_index')->unsigned()->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_street')->nullable();
            $table->integer('address_home')->unsigned()->nullable();
            $table->string('address_block')->nullable();
            $table->integer('address_apartment')->unsigned()->nullable();
            $table->integer('address_porch')->unsigned()->nullable();
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
