<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_members', function (Blueprint $table) {
            $table->id();
            $table->string('staff_no')->nullable();
            $table->string('title')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('oname')->nullable();
            $table->string('gender')->nullable(); 
            $table->string('marital_status')->nullable();
            $table->date('dob')->nullable();
            $table->string('disability')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('no_of_children')->nullable();
            $table->string('no_of_dependant')->nullable();
            $table->string('crbcard_no')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('branchposition_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('email_verify_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('staff_members');
    }
}
