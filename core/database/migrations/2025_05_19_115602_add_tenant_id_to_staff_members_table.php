<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTenantIdToStaffMembersTable extends Migration
{
    public function up(): void
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->after('id')->index()->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }

}
