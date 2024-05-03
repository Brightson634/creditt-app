<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id')->nullable();
            $table->bigInteger('subcategory_id')->nullable();
            $table->bigInteger('paymenttype_id')->nullable();
            $table->string('name')->nullable();
            $table->decimal('amount', 10,0)->default(0);
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('is_refund')->default(1);
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
        Schema::dropIfExists('expenses');
    }
}
