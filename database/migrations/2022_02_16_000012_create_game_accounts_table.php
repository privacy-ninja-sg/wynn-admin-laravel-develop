<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('game_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->integer('game_accounts')->nullable();
            $table->integer('user_games')->nullable();
            $table->timestamps();
        });
    }
}
