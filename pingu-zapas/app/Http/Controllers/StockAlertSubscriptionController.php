<?php

namespace App\Http\Controllers;

use App\Models\StockAlertSubscription;
use App\Models\TallaStock;
use App\Models\Zapatilla;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockAlertSubscriptionController extends Controller
{
    public function store(Request $request, Zapatilla $zapatilla)
    {
        $validated = $request->validate([
            'talla' => 'required|numeric',
        ], [
            'talla.required' => 'Selecciona una talla agotada para activar el aviso.',
            'talla.numeric' => 'La talla seleccionada no es válida.',
        ]);

        $talla = number_format((float) $validated['talla'], 1, '.', '');

        if ($talla > 0) {
            $stock = TallaStock::where('zapatilla_id', $zapatilla->id)
                ->where('talla', $talla)
                ->first();

            if ($stock && $stock->stock > 0) {
                $msg = 'Esa talla ya tiene stock disponible.';
                return $request->ajax() ? response()->json(['message' => $msg, 'status' => 'error'], 422) : back()->with('error', $msg);
            }
        } else {
            // Check if ANY talla has stock
            $hasAnyStock = TallaStock::where('zapatilla_id', $zapatilla->id)
                ->where('stock', '>', 0)
                ->exists();
            
            if ($hasAnyStock) {
                $msg = 'Este producto ya tiene stock en alguna talla.';
                return $request->ajax() ? response()->json(['message' => $msg, 'status' => 'error'], 422) : back()->with('error', $msg);
            }
        }

        $subscription = StockAlertSubscription::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'zapatilla_id' => $zapatilla->id,
                'talla' => $talla,
            ],
            [
                'email' => Auth::user()->email,
            ],
        );

        if (! $subscription->wasRecentlyCreated) {
            $message = 'Ya estabas apuntado para recibir este aviso.';
            return $request->ajax() 
                ? response()->json(['message' => $message, 'status' => 'info'])
                : back()->with('success', $message);
        }

        $message = 'Te avisaremos por correo cuando vuelva a haber stock.';
        return $request->ajax()
            ? response()->json(['message' => $message, 'status' => 'success'])
            : back()->with('success', $message);
    }
}
