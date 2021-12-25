<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goods_id');
            $table->string('pic_desc')->nullable();
            $table->string('pic_url')->default('');
            $table->tinyInteger('is_master')->nullable();
            $table->tinyInteger('pic_order')->nullable();
            $table->tinyInteger('pic_status')->default('1');
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
        Schema::dropIfExists('pic');
    }
}
