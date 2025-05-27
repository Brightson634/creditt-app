<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Services\MailConfigurator;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendNotifyUserOfExceededAttempts extends Notification
{
    use Queueable;

    public $mailInfo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $mailData)
    {
        //
        $this->mailInfo =$mailData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        try {
            // Apply tenant-specific mail configuration
            MailConfigurator::apply(session('tenant'));
            $info = $this->mailInfo;
            return (new MailMessage)
            ->subject('Wrong Password Login Attempts')
            ->greeting('Hello ' .$info['userName'] . ',')
            ->line('There was an attempted login into your account for three times on ')
            ->line($info['loginTime.']) 
            ->line('Activity Details:')
            ->line('IP Address:'.$info['ipAddress'])
            ->line('loginTime:'.$info['loginTime'])
            ->line('Device:'.$info['device'])
            ->line('browser:'.$info['browser'])
            ->line('platform:'.$info['platform'])
            ->line('The next wrong password entry will result in the locking of the account!')
            ->salutation('Best regards!')
            ->salutation(config('app.name'));
        } catch (\Exception $e) {
            \Log::error('Failed to send exceeded login email: ' . $e->getMessage(), [
            ]);
        }
       
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
