<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function build()
    {
        $subject = $this->application->status === 'accepted'
            ? 'Je sollicitatie is geaccepteerd'
            : 'Je sollicitatie is afgewezen';

        return $this->subject($subject)
            ->view('emails.offer-status-changed');
    }
}