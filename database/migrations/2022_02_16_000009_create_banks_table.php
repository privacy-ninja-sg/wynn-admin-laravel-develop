<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('status')->nullable();
            $table->integer('bank_ids')->nullable();
            $table->string('name_th')->nullable();
            $table->string('short_name_th')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->timestamps();
        });
    }
}
