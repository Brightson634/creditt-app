<?php

namespace App\Listeners;

use Jenssegers\Agent\Agent;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLogoutNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        //
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

        // Send email notification
        Mail::to($user->email)->send(new \App\Mail\LogoutNotification(
            $user,
            $ipAddress,
            $logoutTime,
            $device,
            $browser,
            $platform
        ));
    }
}
