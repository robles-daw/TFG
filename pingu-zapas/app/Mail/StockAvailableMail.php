<?php

namespace App\Mail;

use App\Models\StockAlertSubscription;
use App\Models\TallaStock;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StockAvailableMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public StockAlertSubscription $subscription,
        public TallaStock $tallaStock,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu talla ya vuelve a tener stock en Pingu Zapas',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.stock.available',
        );
    }
}
