<?php

namespace App\Events;

use App\Models\Loan;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoanDisbursementEvent implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    /**
     * The loan instance.
     *
     * @var \App\Models\Loan
     */
    public $loan;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Loan $loan
     * @return void
     */
    public function __construct(Loan $loan)
    {
        // Store the loan instance
        $this->loan = $loan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('loan.disbursement.' . $this->loan->id);
    }
}
