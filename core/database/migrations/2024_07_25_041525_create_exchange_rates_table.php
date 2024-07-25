<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('from_currency_id');
             $table->unsignedBigInteger('to_currency_id');
             $table->unsignedBigInteger('branch_id');
             $table->decimal('exchange_rate', 15, 8);
             $table->timestamps();
             $table->foreign('branch_id')->references('id')->on('branches');
             $table->unique(['from_currency_id', 'to_currency_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_rates');
    }
}
