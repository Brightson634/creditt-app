<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LoanReviewedEvent implements ShouldQueue ,ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $loan;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Broadcast on a public channel for loan review
        return new Channel('loan-application');
    }

    /**
     * Get the name of the event to broadcast as.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'loan-application-reviewed';
    }

    /**
     * Broadcast data to be sent to the frontend.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'loan' => $this->loan,
        ];
    }
}
