<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_charges', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('loan_id')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->string('type')->nullable();
            $table->string('detail')->nullable();
            $table->decimal('amount', 10,0)->default(0);
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
        Schema::dropIfExists('loan_charges');
    }
}
