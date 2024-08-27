<?php

namespace App\Listeners;

use App\Models\Member;
use Illuminate\Support\Facades\Log;
use App\Events\LoanDisbursementEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\SendNotificationToLoanApplicant;

class SendDisbursementNotification implements ShouldQueue
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
     * @param  \App\Events\LoanDisbursementEvent  $event
     * @return void
     */
    public function handle(LoanDisbursementEvent $event)
    {
        // Find the loan applicant using the member_id from the loan
        $applicant = Member::find($event->loan->member_id);

        if ($applicant) {
            // Prepare the loan data for the notification
            $fullName = $applicant->fname . ' ' . $applicant->lname;
            $loanData = [
                'id' => $event->loan->id,
                'amount' => $event->loan->disbursment_amount,
                'loan_number' => $event->loan->loan_no,
                'applicant_name' => $fullName,
                'disbursement_date' => $event->loan->disbursement_date, // Add disbursement date
            ];

            try {
                // Send the disbursement notification to the applicant
                $applicant->notify(new SendNotificationToLoanApplicant($loanData));
            } catch (\Exception $e) {
                Log::error('Failed to send loan disbursement notification: ' . $e->getMessage());
            }
        } else {
            Log::warning('Loan disbursement event: Applicant with member_id ' . $event->loan->member_id . ' not found.');
        }
    }
}
