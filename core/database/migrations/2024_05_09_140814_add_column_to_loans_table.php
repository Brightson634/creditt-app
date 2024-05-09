<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('balance_amount');
           
            //
        });
        Schema::table('loans', function (Blueprint $table) {
            $table->decimal('balance_amount')->nullable();
           
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('balance_amount');
            //
        });
        Schema::table('loans', function (Blueprint $table) {
            $table->decimal('balance_amount');
            //
        });
    }
}
