<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->nullable();
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->text('detail')->nullable();
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
        Schema::dropIfExists('member_notifications');
    }
}
