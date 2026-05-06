<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\TallaStock;
use App\Models\User;
use App\Models\Zapatilla;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CartStockGuardTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_is_blocked_when_cart_item_has_no_stock(): void
    {
        $user = User::factory()->create(['rol' => 'cliente']);
        $categoria = Categoria::create([
            'nombre' => 'Basket',
            'slug' => 'basket',
        ]);

        $zapatilla = Zapatilla::create([
            'categoria_id' => $categoria->id,
            'nombre' => 'Pingu Court',
            'slug' => 'pingu-court-' . Str::lower(Str::random(5)),
            'precio' => 110,
            'activo' => true,
        ]);

        TallaStock::create([
            'zapatilla_id' => $zapatilla->id,
            'talla' => 43,
            'stock' => 0,
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession([
                'cart' => [
                    'item-1' => [
                        'id' => $zapatilla->id,
                        'talla' => 43,
                        'quantity' => 1,
                    ],
                ],
            ])
            ->get(route('checkout.index'));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
    }
}
