<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToLoanRepaymentScheduleTable extends Migration
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
            $table->date('payment_date')->after('payment_status')->nullable();
            $table->unsignedBigInteger('added_by')->after('payment_date')->nullable();
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
            $table->dropColumn(['payment_date','added_by']);
        });
    }
}