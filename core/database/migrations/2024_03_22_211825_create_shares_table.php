<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void 
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->decimal('unit_price', 10,0)->default(0);
            $table->decimal('total_share', 10,0)->default(0);
            $table->decimal('minimum_total_share', 10,0)->default(0);
            $table->decimal('maximum_total_share', 10,0)->default(0);
            $table->decimal('minimum_buy_price', 10,0)->default(0);
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
        Schema::dropIfExists('shares');
    }
}
