<?php

namespace App\Mail;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OfferReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Offer $offer) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nieuwe offerte ontvangen voor "'.$this->offer->commission->title.'"',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.offer-received',
        );
    }
}
