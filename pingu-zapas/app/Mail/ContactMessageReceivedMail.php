<?php

namespace App\Mail;

use App\Models\Contacto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contacto $contacto)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo mensaje de contacto: ' . $this->contacto->asunto,
            replyTo: [
                new Address($this->contacto->email, $this->contacto->nombre),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact.received',
            with: [
                'contacto' => $this->contacto,
            ],
        );
    }
}
