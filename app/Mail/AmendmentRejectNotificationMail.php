<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AmendmentRejectNotificationMail extends Mailable
{
    use Queueable, SerializesModels;
public $societyName;
    public $remarks;
    /**
     * Create a new message instance.
     */
   public function __construct($societyName, $remarks)
    {
        $this->societyName = $societyName;
        $this->remarks = $remarks;
    }

    public function build()
    {
        return $this->subject("Amendment Rejected – {$this->societyName}")
                    ->view('emails.amendment.reject');
    }
    /**
     * Get the message content definition.
     */
   
}
