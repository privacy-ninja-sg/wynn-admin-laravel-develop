<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('tel')->nullable();
            $table->string('picture')->nullable();
            $table->string('username');
            $table->string('password')->nullable();
            $table->string('status')->nullable();
            $table->string('bonus')->nullable();
            $table->integer('channel_user')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
