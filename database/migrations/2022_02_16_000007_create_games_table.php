<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->string('banner')->nullable();
            $table->longText('desc')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
