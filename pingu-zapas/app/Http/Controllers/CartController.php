<?php

namespace App\Http\Controllers;

use App\Models\Descuento;
use App\Models\TallaStock;
use App\Models\Zapatilla;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function index()
    {
        return view('cart.index', $this->cartService->buildSummary());
    }

    public function add(Request $request)
    {
        $request->validate([
            'zapatilla_id' => 'required|exists:zapatillas,id',
            'talla' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $zapatilla = Zapatilla::findOrFail($request->zapatilla_id);
        $normalizedTalla = $this->cartService->normalizeTalla($request->talla);
        $stock = TallaStock::where('zapatilla_id', $zapatilla->id)
            ->where('talla', $normalizedTalla)
            ->first();

        if (! $stock || $stock->stock <= 0) {
            return redirect()->back()->with('error', 'La talla seleccionada está agotada.');
        }

        $cart = Session::get('cart', []);
        $cartId = $request->zapatilla_id . '-' . $normalizedTalla;
        $newQuantity = (int) $request->quantity;

        if (isset($cart[$cartId])) {
            $newQuantity += (int) $cart[$cartId]['quantity'];
        }

        if ($newQuantity > $stock->stock) {
            return redirect()->back()->with('error', "Solo hay {$stock->stock} unidades disponibles para esa talla.");
        }

        $cart[$cartId] = [
            'id' => $zapatilla->id,
            'talla' => $normalizedTalla,
            'quantity' => $newQuantity,
        ];

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Producto añadido al carrito.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (! isset($cart[$request->id])) {
            return back()->with('error', 'No hemos encontrado ese producto en el carrito.');
        }

        $item = $cart[$request->id];
        $stock = TallaStock::where('zapatilla_id', $item['id'])
            ->where('talla', $this->cartService->normalizeTalla($item['talla']))
            ->first();

        $availableStock = (int) ($stock?->stock ?? 0);

        if ($availableStock <= 0) {
            return back()->with('error', 'Esta talla se ha agotado y no se puede actualizar la cantidad.');
        }

        if ($request->quantity > $availableStock) {
            return back()->with('error', "Solo quedan {$availableStock} unidades disponibles para esta talla.");
        }

        $cart[$request->id]['quantity'] = (int) $request->quantity;
        Session::put('cart', $cart);

        return back()->with('success', 'Carrito actualizado.');
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = Session::get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Session::put('cart', $cart);
            }

            return back()->with('success', 'Producto eliminado.');
        }
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|exists:descuentos,codigo',
        ]);

        $coupon = Descuento::where('codigo', $request->codigo)->first();
        $subtotal = $this->cartService->buildSummary()['total'];

        if (! $coupon->isValidForSubtotal($subtotal)) {
            return back()->with('error', 'El cupón no es válido o no cumple con el mínimo de compra.');
        }

        Session::put('applied_coupon', $coupon->id);

        return back()->with('success', 'Cupón aplicado correctamente.');
    }

    public function removeCoupon()
    {
        Session::forget('applied_coupon');

        return back()->with('success', 'Cupón eliminado.');
    }
}
