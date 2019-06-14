<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BuddySubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->name . ' wil wandelbuddy worden')->markdown('emails.buddy_submission');
    }
}
