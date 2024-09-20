<?php

namespace App\Listeners;

use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;
use App\Events\LoginAttemptsExceeded;
use Illuminate\Support\Facades\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\SendNotifyUserOfExceededAttempts;

class NotifyUserOfExceededLoginAttempts
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
     * @param  \App\Events\LoginAttemptsExceeded  $event
     * @return void
     */
    public function handle(LoginAttemptsExceeded $event)
    {
        //
        $user = $event->staff;

        // Capture the user's IP address
        $ipAddress = Request::ip();

        // Capture the login time
        $loginTime = now()->format('l, F j, Y \a\t g:i A');

        // Detect device, browser, and platform (OS) using jenssegers/agent
        $agent = new Agent();
        $device = $agent->device();
        $browser = $agent->browser();
        $platform = $agent->platform();

        if($user){
            $mailData = [
                'userName' => $user->fname . ' ' . $user->lname,
                'ipAddress' => $ipAddress,
                'loginTime' => $loginTime,
                'device' => $device,
                'browser' => $browser,
                'platform' => $platform,
            ];
            try {
                // notify user about login attempts
                $user->notify(new SendNotifyUserOfExceededAttempts($mailData));
            } catch (\Exception $e) {
                Log::error('Failed to send notification to user: ' . $e->getMessage());
            }
    
        }
    }
}
