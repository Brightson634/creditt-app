<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_deposits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id')->nullable();
            $table->bigInteger('paymenttype_id')->nullable();
            $table->decimal('amount', 10,0)->default(0);
            $table->string('depositor')->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('account_deposits');
    }
}
