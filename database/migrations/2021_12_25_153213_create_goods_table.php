<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('category_id');
            $table->string('goods_name')->default('');
            $table->string('goods_shorttitle')->nullable();
            $table->string('goods_keywords')->nullable();
            $table->string('goods_property')->nullable();
            $table->text('goods_description')->nullable();
            $table->decimal('goods_price');
            $table->decimal('goods_original_price')->nullable();
            $table->decimal('goods_cost')->nullable();
            $table->tinyInteger('goods_sell_num')->default('0')->nullable();
            $table->tinyInteger('goods_stock')->default('0');
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('goods');
    }
}
