<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_refunds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('expense_id')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->bigInteger('paymenttype_id')->nullable();
            $table->decimal('amount', 10,0)->default(0);
            $table->text('description')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('expense_refunds');
    }
}
