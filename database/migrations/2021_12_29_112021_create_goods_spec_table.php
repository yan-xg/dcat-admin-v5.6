<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_spec', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goods_id');
            $table->string('goods_key')->default('');
            $table->string('goods_value')->default('');
            $table->string('goods_desc')->nullable();
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
        Schema::dropIfExists('goods_spec');
    }
}
