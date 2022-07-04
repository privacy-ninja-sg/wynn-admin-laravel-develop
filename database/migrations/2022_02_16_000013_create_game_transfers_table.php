<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('game_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('game')->nullable();
            $table->integer('transfer_transaction')->nullable();
            $table->timestamps();
        });
    }
}
