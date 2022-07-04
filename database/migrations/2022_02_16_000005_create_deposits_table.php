<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->float('debit', 20, 2);
            $table->float('credit', 20, 2);
            $table->float('balance', 20, 2);
            $table->string('remark')->nullable();
            $table->string('txn_type');
            $table->string('status');
            $table->integer('user_wallet')->nullable();
            $table->timestamps();
        });
    }
}
