<?php

namespace App\Mail;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Offer $offer) {}

    public function build()
    {
        return $this->subject('Confirmation: your offer has been sent')
            ->view('emails.offer-submitted');
    }
}
