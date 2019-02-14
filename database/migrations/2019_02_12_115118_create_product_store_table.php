<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStoreTable extends Migration
{
    public function up()
    {
        Schema::create('product_store', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('external_product_id')->unsigned()->nullable();

            $table->primary(['product_id', 'store_id']);

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_store');
    }
}