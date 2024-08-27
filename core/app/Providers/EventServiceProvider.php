<?php

namespace App\Providers;

use App\Events\LoanApplicationEvent;
use App\Events\LoanDisbursementEvent;
use App\Events\LoanReviewedEvent;
use App\Listeners\SendDisbursementNotification;
use App\Listeners\SendLoanApprovalNotification;
use App\Listeners\SendLoanReviewNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
