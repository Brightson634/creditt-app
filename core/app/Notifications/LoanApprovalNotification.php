<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanApprovalNotification extends Notification
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
        //
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
        $loan = $this->loan;
        $approvalUrl = route('webmaster.loan.approval', ['id' => $loan->loan_no]);
        return (new MailMessage)
                    ->subject('Loan Approval Notification')
                    ->greeting('Hello,')
                    ->line('A new loan application has been submitted that requires your approval.')
                    ->line('Loan ID: ' . $loan->loan_no)
                    ->line('Loan Amount: UGX' . number_format($loan->principal_amount, 2))
                    ->line('Applicant ID: ' . $loan->member_id)
                    ->action('Approve Loan',  $approvalUrl)
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
