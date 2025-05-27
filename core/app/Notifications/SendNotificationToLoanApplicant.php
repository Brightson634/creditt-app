<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Services\MailConfigurator;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendNotificationToLoanApplicant extends Notification
{

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
        try {
            // Apply tenant-specific mail configuration
            MailConfigurator::apply(session('tenant'));

            $loan = $this->loanData;
            $status = $loan['status'];

            $message = (new MailMessage)
                ->subject('Loan Status Notification')
                ->greeting('Hello ' . $loan['applicant_name'] . ',');

            switch ($status) {
                case 0:
                    $message->line('We would like to inform you that your loan has been sent for review:')
                        ->line('Loan Number: ' . $loan['loan_number'])
                        ->line('Loan Amount: UGX ' . number_format($loan['principal_amount'], 2));
                    break;
                case 1:
                case 2:
                    $message->line('We would like to inform you that your loan has been sent for approval:')
                        ->line('Loan Number: ' . $loan['loan_number'])
                        ->line('Loan Amount: UGX ' . number_format($loan['principal_amount'], 2));
                    break;
                case 3:
                    $message->line('We would like to inform you that your loan has been approved:')
                        ->line('Loan Number: ' . $loan['loan_number'])
                        ->line('Loan Amount: UGX ' . number_format($loan['principal_amount'], 2));
                    break;
                case 4:
                    $message->line('We would like to inform you that your loan has been rejected:')
                        ->line('Loan Number: ' . $loan['loan_number'])
                        ->line('Loan Amount: UGX ' . number_format($loan['principal_amount'], 2));
                    break;
                case 5:
                    $message->line('Your loan has been disbursed:')
                        ->line('Loan Number: ' . $loan['loan_number'])
                        ->line('Loan Amount: UGX ' . number_format($loan['amount'], 2))
                        ->line('Disbursement Date: ' . $loan['disbursement_date']);
                    break;
                case 6:
                    $message->line('Your loan has been canceled:')
                        ->line('Loan Number: ' . $loan['loan_number'])
                        ->line('Loan Amount: UGX ' . number_format($loan['amount'], 2));
                    break;
                default:
                    $message->line('There was a problem retrieving your loan status.');
                    break;
            }

            $message->line('Applicant ID: ' . $loan['id'])
                    ->line('Thank you for choosing our services. If you have any questions, please feel free to contact us.')
                    ->salutation('Best regards!');

            return $message;

        } catch (\Exception $e) {
            \Log::error('Loan applicant mail error: ' . $e->getMessage(), [
                'loan_id' => $this->loanData['id'] ?? null,
                'email' => $notifiable->email ?? null,
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
            'loan_id' => $this->loanData['id'],
            'loan_amount' => $this->loanData['amount'],
        ];
    }
}
