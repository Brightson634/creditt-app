<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_no')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('assetgroup_id')->nullable();
            $table->string('serial_no')->nullable(0);
            $table->decimal('cost_price', 10,0)->default(0);
            $table->date('purchase_date')->nullable();
            $table->bigInteger('staff_id')->nullable();
            $table->string('location')->nullable();
            $table->string('warrant_period')->nullable();
            $table->string('depreciation_period')->nullable();
            $table->decimal('depreciation_amount', 10,0)->default(0);
            $table->bigInteger('supplier_id')->nullable();
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
        Schema::dropIfExists('assets');
    }
}
