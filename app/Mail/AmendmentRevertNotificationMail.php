<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AmendmentRevertNotificationMail extends Mailable
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

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject("Amendment Reverted – {$this->societyName}")
                    ->view('emails.amendment.revert');
    }
}
