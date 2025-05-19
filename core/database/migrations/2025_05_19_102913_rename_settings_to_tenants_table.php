<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSettingsToTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up(): void
    {
        Schema::rename('settings', 'tenants');

        Schema::table('tenants', function (Blueprint $table) {
            $table->string('subdomain')->nullable()->unique()->after('id');
            $table->string('custom_domain')->nullable()->unique()->after('subdomain');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['subdomain', 'custom_domain']);
        });

        Schema::rename('tenants', 'settings');
    }
}
