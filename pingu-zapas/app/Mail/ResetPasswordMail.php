<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $resetUrl;

    public function __construct(
        public User $user,
        public string $token,
    ) {
        $this->resetUrl = route('password.reset', [
            'token' => $this->token,
            'email' => $this->user->email,
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recupera tu contrasena en Pingu Zapas',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auth.reset-password',
        );
    }
}
