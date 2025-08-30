<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SocietyRejectNotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $societyName;
    public $remarks;

    public function __construct($societyName, $remarks)
    {
        $this->societyName = $societyName;
        $this->remarks = $remarks;
    }

    public function build()
    {

        Log::info('Sending Society Reject Mail', [
            'societyName' => $this->societyName,

            'remarks' => $this->remarks
        ]);
        return $this->subject("Society Registration Application – Rejected")
            ->view('emails.society.reject');
    }
}
