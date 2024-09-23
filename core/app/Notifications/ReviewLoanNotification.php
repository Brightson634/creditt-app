<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewLoanNotification extends Notification
{
    use Queueable;
    public $loan;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($loan)
    { 
        $this->loan = $loan;
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $loan = $this->loan;
        $reviewUrl = route('webmaster.loan.review', ['id' => $loan->loan_no]);
        return (new MailMessage)
                    ->subject('Loan Application Notification')
                    ->greeting('Hello,')
                    ->line('A new loan application has been submitted that requires your attention.')
                    ->line('Loan ID: ' . $loan->loan_no)
                    ->line('Loan Amount: UGX' . number_format($loan->principal_amount, 2))
                    ->line('Applicant ID: ' . $loan->member_id)
                    ->action('View Details',  $reviewUrl)
                    ->line('Thank you for your prompt attention to this matter.')
                    ->salutation('Best regards!');
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
