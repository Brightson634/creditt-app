<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->bigInteger('accouttype_id')->nullable();
            $table->bigInteger('accountsubtype_id')->nullable();
            $table->bigInteger('currency_id')->nullable(); 
            $table->tinyInteger('has_balance')->default(0);
            $table->decimal('opening_balance', 10,0)->default(0);
            $table->bigInteger('paymenttype_id')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('chart_of_accounts');
    }
}
