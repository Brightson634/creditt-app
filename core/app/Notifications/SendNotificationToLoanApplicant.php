<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendNotificationToLoanApplicant extends Notification implements ShouldQueue
{
    use Queueable;
    
    public $loanData;

    /**
     * Create a new notification instance.
     *
     * @param array $loanData
     * @return void
     */
    public function __construct(array $loanData)
    {
        $this->loanData = $loanData;
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
        $loan = $this->loanData;

        return (new MailMessage)
            ->subject('Loan Disbursement Confirmation')
            ->greeting('Hello ' . $loan['applicant_name'] . ',')
            ->line('We are pleased to inform you that your loan with the following details has been disbursed:')
            ->line('Loan Number: ' . $loan['loan_number']) // Access array values
            ->line('Loan Amount: UGX ' . number_format($loan['amount'], 2))
            ->line('Applicant ID: ' . $loan['id'])
            ->line('Disbursement Date: ' . $loan['disbursement_date'])
            ->line('Thank you for choosing our services. If you have any questions, please feel free to contact us.')
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
            'loan_id' => $this->loanData['id'],
            'loan_amount' => $this->loanData['amount'],
        ];
    }
}
