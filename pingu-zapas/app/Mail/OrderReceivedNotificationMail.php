<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceivedNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pedido $pedido)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo pedido recibido: ' . $this->pedido->numero_pedido,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.received',
            with: [
                'pedido' => $this->pedido,
            ],
        );
    }
}
