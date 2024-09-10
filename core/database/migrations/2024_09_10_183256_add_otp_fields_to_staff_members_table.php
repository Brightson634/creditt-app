<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpFieldsToStaffMembersTable extends Migration
{
    public function up()
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->string('otp')->nullable()->after('password'); // Add OTP column
            $table->timestamp('otp_expires_at')->nullable()->after('otp'); // Add OTP expiration column
        });
    }

    public function down()
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->dropColumn(['otp', 'otp_expires_at']); // Remove columns if rolling back
        });
    }
}
