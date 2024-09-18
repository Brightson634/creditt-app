<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecurityTokenToStaffMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_members', function (Blueprint $table) {
            //
            $table->string('security_token', 64)->nullable()->after('is_locked');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_members', function (Blueprint $table) {
            //
            $table->dropColumn('security_token');
        });
    }
}
