<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ipAddress;
    public $loginTime;
    public $device;
    public $browser;
    public $platform;

    public function __construct($user, $ipAddress, $loginTime, $device, $browser, $platform)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
        $this->loginTime = $loginTime;
        $this->device = $device;
        $this->browser = $browser;
        $this->platform = $platform;
    }

    public function build()
    {
        $secureLink = $this->user->security_token 
            ? route('webmaster.account.secure', ['token' => $this->user->security_token])
            : '#'; 

        return $this->subject('Login Notification')
            ->view('emails.loginNotification')
            ->with([
                'userName' => $this->user->fname . ' ' . $this->user->lname,
                'ipAddress' => $this->ipAddress,
                'loginTime' => $this->loginTime,
                'device' => $this->device,
                'browser' => $this->browser,
                'platform' => $this->platform,
                'loginAtemptStatus' => $this->user->login_attempts,
                'secureLink' => $secureLink,
            ]);
    }
}
