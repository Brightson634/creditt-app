<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCreatedMemberEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $mailData)
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
        return $this->subject('Welcome to ' . $this->mailData['saccoName'])
        ->view('emails.member')
        ->with([
            'saccoName' => $this->mailData['saccoName'],
            'email' => $this->mailData['email'],
            'memberID'=>$this->mailData['memberID'],
            'password' => $this->mailData['password'],
            'loginUrl' => $this->mailData['loginUrl'],
        ]);
    }
}
