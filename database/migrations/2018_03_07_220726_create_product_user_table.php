<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('count')->unsigned()->default(1);
            $table->timestamps();
        });

        Schema::table('product_user', function (Blueprint $table) {
            $table->unique(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_user', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('product_user');
    }
}
