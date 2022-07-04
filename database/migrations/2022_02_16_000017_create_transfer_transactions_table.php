<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transfer_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->integer('amount')->nullable();
            $table->string('status')->nullable();
            $table->integer('user_transfers')->nullable();
            $table->timestamps();
        });
    }
}
