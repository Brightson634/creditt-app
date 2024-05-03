<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('min_amount', 10,0)->default(0);
            $table->string('max_amount', 10,0)->default(0);
            $table->decimal('interest_rate', 10,0)->default(0);
            $table->decimal('interest_value', 10,2)->default(0);
            $table->decimal('duration', 10,0)->default(0);
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
        Schema::dropIfExists('investment_plans');
    }
}
