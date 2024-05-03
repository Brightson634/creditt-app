<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->nullable();
            $table->bigInteger('accounttype_id')->nullable();
            $table->string('fees_id')->nullable();
            $table->string('account_no')->nullable();
            $table->decimal('opening_balance', 10,0)->default(0);
            $table->decimal('current_balance', 10,0)->default(0);
            $table->decimal('available_balance', 10,0)->default(0);
            $table->string('account_purpose')->nullable();
            $table->tinyInteger('account_status')->default(0);
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
        Schema::dropIfExists('member_accounts');
    }
}
