<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id');
            $table->bigInteger('loan_id');
            $table->decimal('loan_amount',10,0)->default(0);
            $table->decimal('repaid_amount',10,0)->default(0);
            $table->decimal('balance_amount',10,0)->default(0);
            $table->string('payment_type')->nullable();
            $table->string('paid_by')->nullable();
            $table->bigInteger('received_by')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('loan_payments');
    }
}
