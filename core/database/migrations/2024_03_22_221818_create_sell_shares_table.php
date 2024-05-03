<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_shares', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->nullable();
            $table->decimal('total_share', 10,0)->default(0);
            $table->decimal('unit_sell_price', 10,0)->default(0);
            $table->decimal('total_amount', 10,0)->default(0);
            $table->date('date')->nullable();
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
        Schema::dropIfExists('sell_shares');
    }
}
