<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application) {}

    public function build()
    {
        $subject = $this->application->status === 'accepted'
            ? 'Your application has been accepted'
            : 'Your application has been rejected';

        return $this->subject($subject)
            ->view('emails.application-status-changed');
    }
}
