<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewTenantIdToCollateralItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collateral_items', function (Blueprint $table) {
            //
            $table->bigInteger('tenant_id')->unsigned()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collateral_items', function (Blueprint $table) {
            //
              $table->dropColumn('tenant_id');
        });
    }
}
