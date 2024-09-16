<?php

namespace App\Providers;

use App\Events\LoanReviewedEvent;
use App\Events\LoanApplicationEvent;
use App\Events\LoanDisbursementEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendLoginNotification;
use App\Listeners\SendLoanReviewNotification;
use App\Listeners\SendDisbursementNotification;
use App\Listeners\SendLoanApprovalNotification;
use App\Listeners\SendLogoutNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Auth\Events\Logout;

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
        LoanDisbursementEvent::class=>[
            SendDisbursementNotification::class,
        ],
        LoginEvent::class => [
            SendLoginNotification::class,
        ],
        Logout::class=>[
            SendLogoutNotification::class,
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
