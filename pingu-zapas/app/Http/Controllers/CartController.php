<?php

namespace App\Http\Controllers;

use App\Models\Zapatilla;
use App\Models\Descuento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
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

        $discount = 0;
        $appliedCoupon = null;

        if (Session::has('applied_coupon')) {
            $coupon = Descuento::find(Session::get('applied_coupon'));
            if ($coupon && $coupon->isValidForSubtotal($total)) {
                $appliedCoupon = $coupon;
                $discount = $coupon->calculateDiscount($total);
            } else {
                Session::forget('applied_coupon');
            }
        }

        return view('cart.index', compact('items', 'total', 'discount', 'appliedCoupon'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'zapatilla_id' => 'required|exists:zapatillas,id',
            'talla' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart', []);
        $zapatilla = Zapatilla::findOrFail($request->zapatilla_id);
        
        $cartId = $request->zapatilla_id . '-' . $request->talla;

        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $request->quantity;
        } else {
            $cart[$cartId] = [
                "id" => $zapatilla->id,
                "talla" => $request->talla,
                "quantity" => $request->quantity
            ];
        }

        Session::put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Producto añadido al carrito.');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = Session::get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            Session::put('cart', $cart);
            return back()->with('success', 'Carrito actualizado.');
        }
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
        
        $cart = Session::get('cart', []);
        $subtotal = 0;
        foreach ($cart as $details) {
            $zapatilla = Zapatilla::find($details['id']);
            if ($zapatilla) {
                $subtotal += $zapatilla->precio * $details['quantity'];
            }
        }

        if (!$coupon->isValidForSubtotal($subtotal)) {
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
