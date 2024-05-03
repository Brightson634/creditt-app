<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanGuarantorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_guarantors', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_member')->default(0);
            $table->bigInteger('member_id')->nullable();
            $table->bigInteger('loan_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->string('occupation')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('loan_guarantors');
    }
}
