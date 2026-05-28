<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application) {}

    public function build()
    {
        return $this->subject('Confirmation: your application has been sent')
            ->view('emails.application-submitted');
    }
}
