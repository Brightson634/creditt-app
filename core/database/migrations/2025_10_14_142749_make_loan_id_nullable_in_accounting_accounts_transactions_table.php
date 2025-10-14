<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeLoanIdNullableInAccountingAccountsTransactionsTable extends Migration
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
             DB::statement('ALTER TABLE accounting_accounts_transactions MODIFY loan_id BIGINT UNSIGNED NULL;');
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
           DB::statement('ALTER TABLE accounting_accounts_transactions MODIFY loan_id BIGINT UNSIGNED NOT NULL;');
        });
    }
}