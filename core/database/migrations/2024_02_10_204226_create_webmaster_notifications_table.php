<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebmasterNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webmaster_notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('webmaster_id')->nullable();
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('url')->nullable();
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
        Schema::dropIfExists('webmaster_notifications');
    }
}
