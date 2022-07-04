<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrettyGameAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('pretty_game_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('desktop_uri')->nullable();
            $table->string('mobile_uri')->nullable();
            $table->longText('raw_data')->nullable();
            $table->integer('game_account_pretty')->nullable();
            $table->timestamps();
        });
    }
}
