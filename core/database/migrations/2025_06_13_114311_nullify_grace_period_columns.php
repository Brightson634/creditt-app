<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullifyGracePeriodColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            //
              DB::statement("ALTER TABLE loans MODIFY grace_period INT DEFAULT 0");
              DB::statement("ALTER TABLE loans MODIFY grace_period_in VARCHAR(20) DEFAULT 'days'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            //
             DB::statement("ALTER TABLE loans MODIFY grace_period INT DEFAULT NULL");
             DB::statement("ALTER TABLE loans MODIFY grace_period_in  DEFAULT NULL");
        });
    }
}
