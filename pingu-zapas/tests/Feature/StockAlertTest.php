<?php

namespace Tests\Feature;

use App\Mail\StockAvailableMail;
use App\Models\Categoria;
use App\Models\StockAlertSubscription;
use App\Models\TallaStock;
use App\Models\User;
use App\Models\Zapatilla;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class StockAlertTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_subscribe_to_an_out_of_stock_size(): void
    {
        $user = User::factory()->create();
        $categoria = Categoria::create([
            'nombre' => 'Lifestyle',
            'slug' => 'lifestyle',
        ]);

        $zapatilla = Zapatilla::create([
            'categoria_id' => $categoria->id,
            'nombre' => 'Pingu Street',
            'slug' => 'pingu-street-' . Str::lower(Str::random(5)),
            'precio' => 90,
            'activo' => true,
        ]);

        TallaStock::create([
            'zapatilla_id' => $zapatilla->id,
            'talla' => 42,
            'stock' => 0,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('stock-alerts.store', $zapatilla), [
                'talla' => 42,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('stock_alert_subscriptions', [
            'user_id' => $user->id,
            'zapatilla_id' => $zapatilla->id,
            'email' => $user->email,
        ]);
    }

    public function test_restock_sends_email_and_removes_pending_subscription(): void
    {
        Mail::fake();

        $user = User::factory()->create();
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

        $stock = TallaStock::create([
            'zapatilla_id' => $zapatilla->id,
            'talla' => 42,
            'stock' => 0,
        ]);

        $subscription = StockAlertSubscription::create([
            'user_id' => $user->id,
            'zapatilla_id' => $zapatilla->id,
            'talla' => 42,
            'email' => $user->email,
        ]);

        $stock->update(['stock' => 3]);

        Mail::assertSent(StockAvailableMail::class, function (StockAvailableMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $this->assertDatabaseMissing('stock_alert_subscriptions', [
            'id' => $subscription->id,
        ]);
    }
}
