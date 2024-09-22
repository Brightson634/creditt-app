<?php

namespace App\Providers;

use App\Events\LoanReviewedEvent;
use App\Events\LoanApplicantEvent;
use Illuminate\Auth\Events\Logout;
use App\Events\LoanApplicationEvent;
use App\Events\LoanDisbursementEvent;
use App\Events\LoginAttemptsExceeded;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendLoginNotification;
use App\Listeners\SendLogoutNotification;
use App\Listeners\SendLoanReviewNotification;
use App\Listeners\SendDisbursementNotification;
use App\Listeners\SendLoanApprovalNotification;
use Illuminate\Auth\Events\Login as LoginEvent;
use App\Listeners\NotifyUserOfExceededLoginAttempts;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LoanApplicationEvent::class =>[
            SendLoanReviewNotification::class
        ],
        LoanReviewedEvent::class=>[
            SendLoanApprovalNotification::class,
        ],
        LoanApplicantEvent::class=>[
            SendDisbursementNotification::class,
        ],
        LoginEvent::class => [
            SendLoginNotification::class,
        ],
        Logout::class=>[
            SendLogoutNotification::class,
        ],
        LoginAttemptsExceeded::class=>[
            NotifyUserOfExceededLoginAttempts::class,
        ]

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
