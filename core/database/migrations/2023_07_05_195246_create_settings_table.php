<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('footerlogo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('system_name')->nullable();
            $table->string('system_slogan')->nullable();
            $table->string('system_description')->nullable();
            $table->string('system_telephone')->nullable();
            $table->string('system_email')->nullable();
            $table->string('system_currency')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('mail_type')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_user')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('mail_encryption')->nullable();
            $table->text('from_email')->nullable();
            $table->string('from_name')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
