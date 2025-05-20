<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_packages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->boolean('is_trial')->default(false);
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
        Schema::dropIfExists('tenant_packages');
    }
}
