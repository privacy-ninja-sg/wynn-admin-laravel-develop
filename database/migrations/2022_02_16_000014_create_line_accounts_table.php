<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('line_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('line')->nullable();
            $table->string('line_client')->nullable();
            $table->integer('user_line')->nullable();
            $table->timestamps();
        });
    }
}
