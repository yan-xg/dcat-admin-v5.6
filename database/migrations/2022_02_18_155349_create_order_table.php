<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_sn')->default('');
            $table->integer('user_id');
            $table->string('remark')->default('');
            $table->smallInteger('order_status');
            $table->string('consignee_name')->default('');
            $table->char('consignee_mobile');
            $table->string('province')->default('');
            $table->string('city')->default('');
            $table->string('district')->default('');
            $table->string('address')->default('');
            $table->smallInteger('payment_method');
            $table->decimal('order_money');
            $table->decimal('district_money');
            $table->decimal('freight_money');
            $table->decimal('payment_money');
            $table->timestamp('pay_time');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
