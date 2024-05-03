<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id')->nullable();
            $table->string('type')->nullable();
            $table->decimal('previous_amount', 10,0)->default(0);
            $table->decimal('amount', 10,0)->default(0);
            $table->decimal('current_amount', 10,0)->default(0);
            $table->text('description')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('account_transactions');
    }
}
