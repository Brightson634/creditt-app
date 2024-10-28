<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentStatusToLoanRepaymentSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_repayment_schedules', function (Blueprint $table) {
            //
            $table->decimal('amount_paid', 10, 2)
                  ->default(0.00) 
                  ->after('amount_due');
            $table->enum('payment_status', ['pending', 'partial', 'paid'])
            ->default('pending')->after('amount_paid');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_repayment_schedules', function (Blueprint $table) {
            //
            $table->dropColumn(['payment_status','amount_due']);
        });
    }
}
