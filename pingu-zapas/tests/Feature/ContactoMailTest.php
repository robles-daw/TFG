<?php

namespace Tests\Feature;

use App\Mail\ContactMessageConfirmationMail;
use App\Mail\ContactMessageReceivedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactoMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_sends_internal_and_confirmation_emails(): void
    {
        Mail::fake();
        Config::set('mail.contact_notification_to', 'contacto@pingu.test');

        $response = $this->post(route('contacto.store'), [
            'nombre' => 'Alex Robles',
            'email' => 'alex@example.com',
            'telefono' => '600123123',
            'asunto' => 'Consulta de tallas',
            'mensaje' => 'Necesito ayuda con una talla concreta.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Mail::assertSent(ContactMessageReceivedMail::class, function (ContactMessageReceivedMail $mail) {
            return $mail->hasTo('contacto@pingu.test');
        });

        Mail::assertSent(ContactMessageConfirmationMail::class, function (ContactMessageConfirmationMail $mail) {
            return $mail->hasTo('alex@example.com');
        });
    }
}
