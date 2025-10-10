<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoanIdColumnToAccountingAccountsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_accounts_transactions', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('loan_id')->after('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounting_accounts_transactions', function (Blueprint $table) {
            //
            $table->dropColumn('loan_id');
        });
    }
}