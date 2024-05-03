<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transfers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('debit_account')->nullable();
            $table->bigInteger('credit_account')->nullable();
            $table->decimal('amount', 10,0)->default(0);
            $table->date('date')->nullable();
            $table->string('attachment')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_transfers');
    }
}
