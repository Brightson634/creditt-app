<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->integer('default_loan_repayment_account')->default(0);
            $table->integer('default_investment_account')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->dropColumn('numb_of_approving_authorities');
            $table->dropColumn('numb_of_reviewing_authorities');
        });
    }
}
