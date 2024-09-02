<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoanApplicationEvent implements ShouldBroadcast
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
    public function broadcastAs()
    {
        return 'loan-application-review';
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('loan-application');
    }

    public function broadcastWith()
    {
        return ['loan' => $this->loan];
    }
}
