<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            // Adding columns for next of kin information
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_contact')->nullable();
            $table->string('next_of_kin_relationship')->nullable();

            // Adding columns for emergency contact information
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            $table->string('employer')->nullable();
            $table->string('work_address')->nullable();

            // Adding column for current address
            $table->text('current_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            // Dropping columns for next of kin information
            $table->dropColumn('next_of_kin_name');
            $table->dropColumn('next_of_kin_contact');
            $table->dropColumn('next_of_kin_relationship');

            // Dropping columns for emergency contact information
            $table->dropColumn('emergency_contact_name');
            $table->dropColumn('emergency_contact_phone');

            // Dropping columns for occupation and work information
            $table->dropColumn('employer');
            $table->dropColumn('work_address');

            // Dropping column for current address
            $table->dropColumn('current_address');
        });
    }
}
