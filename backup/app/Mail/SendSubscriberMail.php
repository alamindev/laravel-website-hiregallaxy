<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSubscriberMail extends Mailable
{
    use Queueable, SerializesModels;
    public $jobs;
    // public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobs)
    {
        $this->jobs = $jobs;
        // $this->email = $email;
        $this->subject("Latest Job Posts | " . config('app.name'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send-subscriber-email');
    }
}
