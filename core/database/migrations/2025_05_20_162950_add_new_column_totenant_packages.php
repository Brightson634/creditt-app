<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnTotenantPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tenant_packages', function (Blueprint $table) {
            //
            $table->boolean('status')->default(false)->after('is_trial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('branches', function (Blueprint $table) {
            //
            $table->dropColumn('status');
        });
    }
}
