<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_account_id_last')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('status')->nullable();
            $table->integer('bank_accounts')->nullable();
            $table->integer('user_banks')->nullable();
            $table->timestamps();
        });
    }
}
