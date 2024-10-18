<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LogoutNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ipAddress;
    public $logoutTime;
    public $device;
    public $browser;
    public $platform;

    public function __construct($user, $ipAddress, $logoutTime, $device, $browser, $platform)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
        $this->logoutTime = $logoutTime;
        $this->device = $device;
        $this->browser = $browser;
        $this->platform = $platform;
    }

    public function build()
    {
        $secureLink = $this->user->security_token 
            ? route('webmaster.account.secure', ['token' => $this->user->security_token])
            : '#'; 
        return $this->subject('Logout Notification')
            ->view('emails.logoutNotification')
            ->with([
                'userName' => $this->user->fname.' '.$this->user->lname,
                'ipAddress' => $this->ipAddress,
                'logoutTime' => $this->logoutTime,
                'device' => $this->device,
                'browser' => $this->browser,
                'platform' => $this->platform,
                'secureLink' =>$secureLink
            ]);
    }
}
