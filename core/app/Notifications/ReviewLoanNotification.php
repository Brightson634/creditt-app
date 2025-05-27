<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Services\MailConfigurator;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

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
        try {
            // Apply tenant-specific mail configuration
            $tenant =  session('tenant');
            MailConfigurator::apply($tenant);

            $loan = $this->loan;
            $reviewUrl = route('webmaster.loan.review', ['id' => $loan->loan_no]);

            return (new MailMessage)
                ->subject('Loan Application Notification')
                ->greeting('Hello,')
                ->line('A new loan application has been submitted that requires your attention.')
                ->line('Loan ID: ' . $loan->loan_no)
                ->line('Loan Amount: UGX' . number_format($loan->principal_amount, 2))
                ->line('Applicant ID: ' . $loan->member_id)
                ->action('View Details', $reviewUrl)
                ->line('Thank you for your prompt attention to this matter.')
                ->salutation('Best regards!');

        } catch (\Exception $e) {
            //Log the error and avoid interrupting the app flow
            \Log::error('Failed to generate loan review mail notification: ' . $e->getMessage(), [
                'loan_id' => $this->loan->id ?? null,
                'notifiable_id' => $notifiable->id ?? null,
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
