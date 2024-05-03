<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_no')->nullable();
            $table->string('loan_type')->nullable();
            $table->bigInteger('member_id')->nullable();
            $table->bigInteger('group_id')->nullable();
            $table->decimal('principal_amount', 10,0)->default(0);
            $table->bigInteger('loanproduct_id')->nullable();
            $table->decimal('loan_period', 10,0)->default(0);
            $table->decimal('interest_amount', 10,0)->default(0);
            $table->decimal('repayment_amount', 10,0)->default(0);
            $table->date('end_date')->nullable();
            $table->string('fees_id')->nullable();
            $table->decimal('fees_total', 10,0)->default(0);
            $table->string('payment_mode')->nullable();
            $table->decimal('cash_amount', 10,0)->default(0);
            $table->bigInteger('account_id')->nullable();
            $table->decimal('loan_principal', 10,0)->default(0);
            $table->decimal('disbursment_amount', 10,0)->default(0);
            $table->text('loan_purpose')->nullable();
            $table->bigInteger('staff_id')->nullable();
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
        Schema::dropIfExists('member_loans');
    }
}
