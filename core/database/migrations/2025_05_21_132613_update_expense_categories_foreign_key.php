<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExpenseCategoriesForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_categories', function (Blueprint $table) {
            // Drop the old foreign key that references the 'business' table
            DB::statement('ALTER TABLE expense_categories DROP FOREIGN KEY expense_categories_business_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('expense_categories', function (Blueprint $table) {
            // Recreate the old foreign key if you ever roll back
            $table->foreign('tenant_id')->references('id')->on('business')->onDelete('cascade');
        });
    }
}
