<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffIdAndProofOfPaymentAndPaymentVerified extends Migration
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
            $table->unsignedBigInteger('verified_by')->after('payment_status')->default(0);
            $table->boolean('is_verified_payment')->after('verified_by')->default(false);
            $table->string('proof_of_payment')->after('is_verified_payment')->nullable();
            $table->decimal('balance_amount', 15, 2)->after('amount_paid')->default(0.00);
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
            $table->dropColumn(['verified_by','is_verified_payment','proof_of_payment','balance_amount']);
        });
    }
}
