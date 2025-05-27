<?php

namespace App\Listeners;

use Jenssegers\Agent\Agent;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class SendLogoutNotification
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;

        // Capture the user's IP address
        $ipAddress = Request::ip();

        // Capture the logout time
        $logoutTime = now()->format('l, F j, Y \a\t g:i A');

        // Detect device, browser, and platform (OS) using jenssegers/agent
        $agent = new Agent();
        $device = $agent->device();
        $browser = $agent->browser();
        $platform = $agent->platform();

        try {
            if (method_exists($user, 'tenant') && $user->tenant) {
                $tenant = $user->tenant;
                // $tenant->smtp_password = decrypt($tenant->smtp_password);
                \App\Services\MailConfigurator::apply($tenant);
            }

            // Send email
            Mail::to($user->email)->send(new \App\Mail\LogoutNotification(
                $user,
                $ipAddress,
                $logoutTime,
                $device,
                $browser,
                $platform
            ));
        } catch (\Exception $e) {
            Log::error("Logout email failed for user ID {$user->id}: " . $e->getMessage());
            
        }
    }
}
