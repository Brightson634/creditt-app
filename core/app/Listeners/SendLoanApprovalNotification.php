<?php

namespace App\Listeners;

use App\Events\LoanReviewedEvent;
use App\Models\StaffMember;
use App\Notifications\LoanApprovalNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

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
        $users = \App\Models\StaffMember::whereHas('roles.permissions', function ($query) use ($permissions) {
            $query->whereIn('name', $permissions);
        })->get();
        foreach ($users as $user) {
            $user->notify(new LoanApprovalNotification($event->loan));
        }
    }
}
