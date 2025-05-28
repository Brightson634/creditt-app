<?php

namespace App\Listeners;

use App\Models\StaffMember;
use App\Events\LoanReviewedEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LoanApprovalNotification;

class SendLoanApprovalNotification
{
    /**
     * Handle the event.
     *
     * @param  LoanReviewedEvent  $event
     * @return void
     */
    public function handle(LoanReviewedEvent $event)
    {
        // Notify users (for example, all users with any of the specified permissions)
        $permissions = ['approve_loans','reject_loans','disburse_loans'];
        $users = \App\Models\StaffMember::whereHas('role.permissions', function ($query) use ($permissions) {
            $query->whereIn('name', $permissions);
        })->get();
        foreach ($users as $user) {
        
            try {
                $user->notify(new LoanApprovalNotification($event->loan));
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
