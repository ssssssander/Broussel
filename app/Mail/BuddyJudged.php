<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BuddyJudged extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $status;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $status, $password)
    {
        $this->name = $name;
        $this->status = $status;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Over je wandelbuddy inschrijving')->markdown('emails.buddy_judged');
    }
}
