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
            $table->string('nickname')->default('');
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar_url')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->integer('ipone')->nullable();
            $table->char('language')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('openid')->default('');
            $table->string('token')->default('');
            $table->tinyInteger('status')->default('1')->nullable();
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
        Schema::dropIfExists('users');
    }
}
