<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInterestRatePrecisionOnLoanProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          DB::statement("ALTER TABLE loan_products MODIFY interest_rate DECIMAL(10,4)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
         DB::statement("ALTER TABLE loan_products MODIFY interest_rate DECIMAL(10,0)");
    }
}
