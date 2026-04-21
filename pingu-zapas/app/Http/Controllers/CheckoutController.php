<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Zapatilla;
use App\Models\Descuento;
use App\Models\TallaStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $items = [];
        $total = 0;
        foreach ($cart as $id => $details) {
            $zapatilla = Zapatilla::find($details['id']);
            if ($zapatilla) {
                $subtotal = $zapatilla->precio * $details['quantity'];
                $total += $subtotal;
                $items[] = [
                    'id' => $details['id'],
                    'zapatilla' => $zapatilla,
                    'talla' => $details['talla'],
                    'quantity' => $details['quantity'],
                    'subtotal' => $subtotal
                ];
            }
        }

        $user = Auth::user();
        $discount = 0;
        if (Session::has('applied_coupon')) {
            $coupon = Descuento::find(Session::get('applied_coupon'));
            if ($coupon && $coupon->isValidForSubtotal($total)) {
                $discount = $coupon->calculateDiscount($total);
            }
        }

        return view('cart.checkout', compact('items', 'total', 'discount', 'user'));
    }

    public function process(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $request->validate([
            'nombre_envio' => 'required|string|max:255',
            'direccion_envio' => 'required|string',
            'ciudad_envio' => 'required|string|max:255',
            'codigo_postal_envio' => 'required|string|max:20',
            'pais_envio' => 'required|string|max:255',
            'telefono_contacto' => 'required|string|max:255',
            'metodo_pago' => 'required|string|max:255',
        ]);

        return DB::transaction(function () use ($request, $cart) {
            $total = 0;
            $itemsToProcess = [];

            foreach ($cart as $id => $details) {
                $zapatilla = Zapatilla::findOrFail($details['id']);
                
                // Check stock
                $stock = TallaStock::where('zapatilla_id', $zapatilla->id)
                    ->where('talla', $details['talla'])
                    ->first();

                if (!$stock || $stock->stock < $details['quantity']) {
                    throw new \Exception("Stock insuficiente para: " . $zapatilla->nombre . " talla " . $details['talla']);
                }

                $subtotal = $zapatilla->precio * $details['quantity'];
                $total += $subtotal;
                $itemsToProcess[] = [
                    'zapatilla_id' => $zapatilla->id,
                    'talla' => $details['talla'],
                    'cantidad' => $details['quantity'],
                    'precio_unitario' => $zapatilla->precio,
                    'subtotal' => $subtotal
                ];
            }

            $gastosEnvio = $total > 150 ? 0 : 9.99;
            
            $discount = 0;
            $descuento_id = null;
            if (Session::has('applied_coupon')) {
                $coupon = Descuento::find(Session::get('applied_coupon'));
                if ($coupon && $coupon->isValidForSubtotal($total)) {
                    $descuento_id = $coupon->id;
                    $discount = $coupon->calculateDiscount($total);
                    $coupon->increment('usos_actuales');
                }
            }

            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'descuento_id' => $descuento_id,
                'numero_pedido' => 'PED-' . strtoupper(Str::random(10)),
                'estado' => 'pendiente',
                'subtotal' => $total,
                'descuento_aplicado' => $discount,
                'gastos_envio' => $gastosEnvio,
                'total' => ($total - $discount) + $gastosEnvio,
                'nombre_envio' => $request->nombre_envio,
                'direccion_envio' => $request->direccion_envio,
                'ciudad_envio' => $request->ciudad_envio,
                'codigo_postal_envio' => $request->codigo_postal_envio,
                'pais_envio' => $request->pais_envio,
                'telefono_contacto' => $request->telefono_contacto,
                'metodo_pago' => $request->metodo_pago,
                'referencia_pago' => 'REF-' . Str::random(8),
            ]);

            foreach ($itemsToProcess as $itemData) {
                $itemData['pedido_id'] = $pedido->id;
                PedidoItem::create($itemData);

                // Reduce stock
                TallaStock::where('zapatilla_id', $itemData['zapatilla_id'])
                    ->where('talla', $itemData['talla'])
                    ->decrement('stock', $itemData['cantidad']);
            }

            Session::forget('cart');
            Session::forget('applied_coupon');

            return redirect()->route('pedidos.show', $pedido)->with('success', 'Pedido realizado correctamente.');
        });
    }
}
