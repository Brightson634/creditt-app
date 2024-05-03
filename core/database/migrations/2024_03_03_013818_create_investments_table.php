<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->string('investment_no')->nullable();
            $table->string('investor_type')->nullable();
            $table->bigInteger('investor_id')->nullable();
            $table->decimal('investment_amount', 10,0)->default(0);
            $table->bigInteger('investmentplan_id')->nullable();
            $table->decimal('investment_period', 10,0)->default(0);
            $table->decimal('interest_amount', 10,0)->default(0);
            $table->decimal('roi_amount', 10,0)->default(0);
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('investments');
    }
}
