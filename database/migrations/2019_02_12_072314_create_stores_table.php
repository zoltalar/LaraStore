<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191);
            $table->string('base_url', 191)->unique();
            $table->tinyInteger('type_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
}