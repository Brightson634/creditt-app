<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

class SendLoginNotification
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        // Capture the user's IP address
        $ipAddress = Request::ip();

        // Capture the login time
        $loginTime = now()->format('l, F j, Y \a\t g:i A');

        // Detect device, browser, and platform (OS)
        $agent = new Agent();
        $device = $agent->device();
        $browser = $agent->browser();
        $platform = $agent->platform();

        try {
            // Optional: Apply tenant-specific SMTP config
            if (method_exists($user, 'tenant') && $user->tenant) {
                $tenant = $user->tenant;
                // $tenant->smtp_password = decrypt($tenant->smtp_password);
                \App\Services\MailConfigurator::apply($tenant);
            }

            // Send login notification
            Mail::to($user->email)->send(new \App\Mail\LoginNotification(
                $user,
                $ipAddress,
                $loginTime,
                $device,
                $browser,
                $platform
            ));
        } catch (\Exception $e) {
            Log::error("Login email failed for user ID {$user->id}: " . $e->getMessage());
        }
    }
}
