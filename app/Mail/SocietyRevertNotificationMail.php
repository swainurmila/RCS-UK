<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SocietyRevertNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $societyName;
    public $documentName;
    public $remarks;

    public function __construct($societyName, $documentName, $remarks)
    {
        $this->societyName = $societyName;
        $this->documentName = $documentName;
        $this->remarks = $remarks;
    }

    public function build()
    {
             Log::info('Sending Society Revert Mail', [
            'societyName' => $this->societyName,
            'documentName' => $this->documentName,
            'remarks' => $this->remarks
        ]);
        return $this->subject("Document Reverted for Further Action - {$this->documentName}")
                    ->view('emails.society.revert');
    }
}
