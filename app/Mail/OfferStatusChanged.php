<?php

namespace App\Mail;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Offer $offer) {}

    public function build()
    {
        $subject = $this->offer->status === 'accepted'
            ? 'Your offer has been accepted'
            : 'Your offer has been rejected';

        return $this->subject($subject)
            ->view('emails.offer-status-changed');
    }
}
