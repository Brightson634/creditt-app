<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
        $loan = $this->loanData;
        $status = $loan['status'];

        switch ($status) {
            case 0:
                return (new MailMessage)
                    ->subject('Loan Status Notification')
                    ->greeting('Hello ' . $loan['applicant_name'] . ',')
                    ->line('We would like to inform you that your loan with the following details has been sent for review:')
                    ->line('Loan Number: ' . $loan['loan_number']) // Access array values
                    ->line('Loan Amount: UGX ' . number_format($loan['principal_amount'], 2))
                    ->line('Applicant ID: ' . $loan['id'])
                    ->line('Thank you for choosing our services. If you have any questions, please feel free to contact us.')
                    ->salutation('Best regards!');
            case 1:

            case 2:
                return (new MailMessage)
                    ->subject('Loan Status Notification')
                    ->greeting('Hello ' . $loan['applicant_name'] . ',')
                    ->line('We would like to inform you that your loan with the following details has been sent for approval:')
                    ->line('Loan Number: ' . $loan['loan_number']) // Access array values
                    ->line('Loan Amount: UGX ' . number_format($loan['principal_amount'], 2))
                    ->line('Applicant ID: ' . $loan['id'])
                    ->line('Thank you for choosing our services. If you have any questions, please feel free to contact us.')
                    ->salutation('Best regards!');
            case 3:

            case 4:
                return (new MailMessage)
                    ->subject('Loan Status Notification')
                    ->greeting('Hello ' . $loan['applicant_name'] . ',')
                    ->line('We would like to inform you that your loan with the following details has been rejected:')
                    ->line('Loan Number: ' . $loan['loan_number']) // Access array values
                    ->line('Loan Amount: UGX ' . number_format($loan['amount'], 2))
                    ->line('Applicant ID: ' . $loan['id'])
                    ->line('Thank you for choosing our services. If you have any questions, please feel free to contact us.')
                    ->salutation('Best regards!');
            case 5:
                return (new MailMessage)
                    ->subject('Loan Status Notification')
                    ->greeting('Hello ' . $loan['applicant_name'] . ',')
                    ->line('We are pleased to inform you that your loan with the following details has been disbursed:')
                    ->line('Loan Number: ' . $loan['loan_number']) // Access array values
                    ->line('Loan Amount: UGX ' . number_format($loan['amount'], 2))
                    ->line('Applicant ID: ' . $loan['id'])
                    ->line('Disbursement Date: ' . $loan['disbursement_date'])
                    ->line('Thank you for choosing our services. If you have any questions, please feel free to contact us.')
                    ->salutation('Best regards!');
            case 6:
                return (new MailMessage)
                    ->subject('Loan Status Notification')
                    ->greeting('Hello ' . $loan['applicant_name'] . ',')
                    ->line('We would like to inform you that your loan with the following details has been canceled:')
                    ->line('Loan Number: ' . $loan['loan_number']) // Access array values
                    ->line('Loan Amount: UGX ' . number_format($loan['amount'], 2))
                    ->line('Applicant ID: ' . $loan['id'])
                    ->line('Thank you for choosing our services. If you have any questions, please feel free to contact us.')
                    ->salutation('Best regards!');
            default:
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
