<?php

namespace App\Http\Controllers;

use App\Mail\OrderInvoiceMail;
use App\Mail\OrderReceivedNotificationMail;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\TallaStock;
use App\Models\Zapatilla;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function index()
    {
        $summary = $this->cartService->buildSummary();

        if (empty($summary['items'])) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        if ($summary['hasStockIssues']) {
            return redirect()->route('cart.index')->with('error', 'Hay productos sin stock suficiente en tu carrito. Revísalo antes de pagar.');
        }

        return view('cart.checkout', [
            'items' => $summary['items'],
            'total' => $summary['total'],
            'discount' => $summary['discount'],
            'user' => Auth::user(),
        ]);
    }

    public function process(Request $request): RedirectResponse
    {
        $summary = $this->cartService->buildSummary();

        if (empty($summary['items'])) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        if ($summary['hasStockIssues']) {
            return redirect()->route('cart.index')->with('error', 'No puedes tramitar el pedido mientras haya productos sin stock suficiente.');
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

        $pedido = DB::transaction(function () use ($request, $summary) {
            $total = 0;
            $itemsToProcess = [];

            foreach ($summary['items'] as $details) {
                $zapatilla = Zapatilla::findOrFail($details['id']);
                $stock = TallaStock::where('zapatilla_id', $zapatilla->id)
                    ->where('talla', $details['talla'])
                    ->first();

                if (! $stock || $stock->stock < $details['quantity']) {
                    throw new \Exception('Stock insuficiente para: ' . $zapatilla->nombre . ' talla ' . $details['talla']);
                }

                $subtotal = $zapatilla->precio * $details['quantity'];
                $total += $subtotal;
                $itemsToProcess[] = [
                    'zapatilla_id' => $zapatilla->id,
                    'talla' => $details['talla'],
                    'cantidad' => $details['quantity'],
                    'precio_unitario' => $zapatilla->precio,
                    'subtotal' => $subtotal,
                ];
            }

            if ($summary['appliedCoupon']) {
                $summary['appliedCoupon']->increment('usos_actuales');
            }

            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'descuento_id' => $summary['appliedCoupon']?->id,
                'numero_pedido' => 'PED-' . strtoupper(Str::random(10)),
                'estado' => 'pendiente',
                'subtotal' => $total,
                'descuento_aplicado' => $summary['discount'],
                'gastos_envio' => $summary['shipping'],
                'total' => ($total - $summary['discount']) + $summary['shipping'],
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

                TallaStock::where('zapatilla_id', $itemData['zapatilla_id'])
                    ->where('talla', $itemData['talla'])
                    ->decrement('stock', $itemData['cantidad']);
            }

            session()->forget('cart');
            session()->forget('applied_coupon');

            return $pedido;
        });

        $pedido->load(['items.zapatilla', 'user']);
        $this->sendOrderEmails($pedido);

        return redirect()->route('pedidos.show', $pedido)->with('success', 'Pedido realizado correctamente.');
    }

    private function sendOrderEmails(Pedido $pedido): void
    {
        try {
            $notificationRecipient = config('mail.order_notification_to');

            if (! empty($notificationRecipient)) {
                Mail::to($notificationRecipient)->send(new OrderReceivedNotificationMail($pedido));
            }

            if (! empty($pedido->user?->email)) {
                Mail::to($pedido->user->email)->send(new OrderInvoiceMail($pedido));
            }
        } catch (Throwable $exception) {
            Log::warning('No se pudieron enviar los emails del pedido.', [
                'pedido_id' => $pedido->id,
                'numero_pedido' => $pedido->numero_pedido,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
