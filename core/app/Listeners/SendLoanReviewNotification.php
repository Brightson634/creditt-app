<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\LoanApplicationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ReviewLoanNotification;

class SendLoanReviewNotification 
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
     * @param  \App\Events\LoanApplicationEvent  $event
     * @return void
     */
    public function handle(LoanApplicationEvent $event)
    {

      // Notify users (for example, all users with any of the specified permissions)
        $permissions = ['review_loans', 'approve_loans','reject_loans','disburse_loans'];
        $users = \App\Models\StaffMember::whereHas('role.permissions', function ($query) use ($permissions) {
            $query->whereIn('name', $permissions);
        })->get();
        foreach ($users as $user) {
            try {
                $user->notify(new ReviewLoanNotification($event->loan));
            } catch (\Exception $e) {
                // Log the error without disrupting the flow
                Log::error('Failed to send loan review notification to user ' . $user->id, [
                    'error' => $e->getMessage(),
                    'loan_id' => $event->loan->id,
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }
    }
}
