<?php

namespace Tests\Feature;

use App\Mail\OrderInvoiceMail;
use App\Mail\OrderReceivedNotificationMail;
use App\Models\Categoria;
use App\Models\TallaStock;
use App\Models\User;
use App\Models\Zapatilla;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class CheckoutMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_sends_notification_and_invoice_emails(): void
    {
        Mail::fake();
        Config::set('mail.order_notification_to', 'pedidos@pingu.test');

        $user = User::factory()->create([
            'rol' => 'cliente',
            'telefono' => '600123123',
            'direccion' => 'Calle Falsa 123',
            'ciudad' => 'Madrid',
            'codigo_postal' => '28001',
            'pais' => 'Espana',
        ]);

        $categoria = Categoria::create([
            'nombre' => 'Running',
            'slug' => 'running',
        ]);

        $zapatilla = Zapatilla::create([
            'categoria_id' => $categoria->id,
            'nombre' => 'Pingu Runner',
            'slug' => 'pingu-runner-' . Str::lower(Str::random(5)),
            'precio' => 120,
            'activo' => true,
        ]);

        TallaStock::create([
            'zapatilla_id' => $zapatilla->id,
            'talla' => 42,
            'stock' => 5,
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession([
                'cart' => [
                    'item-1' => [
                        'id' => $zapatilla->id,
                        'talla' => 42,
                        'quantity' => 2,
                    ],
                ],
            ])
            ->post(route('checkout.process'), [
                'nombre_envio' => 'Cliente Demo',
                'direccion_envio' => 'Calle Mayor 1',
                'ciudad_envio' => 'Madrid',
                'codigo_postal_envio' => '28001',
                'pais_envio' => 'Espana',
                'telefono_contacto' => '600123123',
                'metodo_pago' => 'tarjeta',
            ]);

        $response->assertRedirect();

        Mail::assertSent(OrderReceivedNotificationMail::class, function (OrderReceivedNotificationMail $mail) {
            return $mail->hasTo('pedidos@pingu.test');
        });

        Mail::assertSent(OrderInvoiceMail::class, function (OrderInvoiceMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}
