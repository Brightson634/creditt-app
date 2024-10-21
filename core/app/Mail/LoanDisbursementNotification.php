<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoanDisbursementNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        //
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Loan Disbursement Notification')
        ->view('emails.disbursementNote')
        ->with([
            'saccoName' => $this->mailData['saccoName'],
            'loan' => $this->mailData['loan'],
            'saccoEmail'=>$this->mailData['saccoEmail'],
            'saccoTel'=>$this->mailData['saccoTel']
        ]);
    }
}
