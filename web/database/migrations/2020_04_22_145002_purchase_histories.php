<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PurchaseHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('purchase_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->integer('price');
            $table->integer('quntitiy');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('purchase_histories');
    }
}
