<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanCollateralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_collaterals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id');
            $table->bigInteger('loan_id')->nullable();
            $table->bigInteger('collateral_item_id');
            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->double('estimate_value')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('loan_collaterals');
    }
}
