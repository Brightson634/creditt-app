<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovingAndReviewingAuthoritiesToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->integer('numb_of_approving_authorities')->default(1);
            $table->integer('numb_of_reviewing_authorities')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->dropColumn('numb_of_approving_authorities');
            $table->dropColumn('numb_of_reviewing_authorities');
        });
    }
}
