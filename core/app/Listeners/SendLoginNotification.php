<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Jenssegers\Agent\Agent;
class SendLoginNotification
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
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //
        $user = $event->user;

        // Capture the user's IP address
        $ipAddress = Request::ip();

        // Capture the login time
        $loginTime = now()->format('l, F j, Y \a\t g:i A');

        // Detect device, browser, and platform (OS) using jenssegers/agent
        $agent = new Agent();
        $device = $agent->device();
        $browser = $agent->browser();
        $platform = $agent->platform();

        // Send email notification
        Mail::to($user->email)->send(new \App\Mail\LoginNotification(
            $user,
            $ipAddress,
            $loginTime,
            $device,
            $browser,
            $platform
        ));;

    }
}
