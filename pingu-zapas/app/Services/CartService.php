<?php

namespace App\Services;

use App\Models\Descuento;
use App\Models\StockAlertSubscription;
use App\Models\TallaStock;
use App\Models\Zapatilla;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function buildSummary(): array
    {
        $cart = Session::get('cart', []);
        $items = [];
        $subtotal = 0;
        $hasStockIssues = false;

        foreach ($cart as $cartId => $details) {
            $zapatilla = Zapatilla::find($details['id']);

            if (! $zapatilla) {
                continue;
            }

            $normalizedTalla = $this->normalizeTalla($details['talla']);
            $stock = TallaStock::where('zapatilla_id', $zapatilla->id)
                ->where('talla', $normalizedTalla)
                ->first();

            $availableStock = (int) ($stock?->stock ?? 0);
            $quantity = (int) $details['quantity'];
            $stockIssue = $availableStock < $quantity;
            $stockIssueMessage = null;

            if ($availableStock <= 0) {
                $stockIssueMessage = 'Esta talla está agotada ahora mismo.';
            } elseif ($stockIssue) {
                $stockIssueMessage = "Solo quedan {$availableStock} unidades para esta talla.";
            }

            $itemSubtotal = $zapatilla->precio * $quantity;
            $subtotal += $itemSubtotal;
            $hasStockIssues = $hasStockIssues || $stockIssue;

            $alreadySubscribed = false;
            if (Auth::check() && $availableStock <= 0) {
                $alreadySubscribed = StockAlertSubscription::where('user_id', Auth::id())
                    ->where('zapatilla_id', $zapatilla->id)
                    ->where('talla', $normalizedTalla)
                    ->exists();
            }

            $items[$cartId] = [
                'id' => $details['id'],
                'zapatilla' => $zapatilla,
                'talla' => $normalizedTalla,
                'quantity' => $quantity,
                'subtotal' => $itemSubtotal,
                'available_stock' => $availableStock,
                'has_stock_issue' => $stockIssue,
                'stock_issue_message' => $stockIssueMessage,
                'already_subscribed' => $alreadySubscribed,
            ];
        }

        $discount = 0;
        $appliedCoupon = null;

        if (Session::has('applied_coupon')) {
            $coupon = Descuento::find(Session::get('applied_coupon'));
            if ($coupon && $coupon->isValidForSubtotal($subtotal)) {
                $appliedCoupon = $coupon;
                $discount = $coupon->calculateDiscount($subtotal);
            } else {
                Session::forget('applied_coupon');
            }
        }

        $shipping = $subtotal > 150 ? 0 : 9.99;

        return [
            'items' => $items,
            'total' => $subtotal,
            'discount' => $discount,
            'appliedCoupon' => $appliedCoupon,
            'shipping' => $shipping,
            'grandTotal' => ($subtotal - $discount) + $shipping,
            'hasStockIssues' => $hasStockIssues,
        ];
    }

    public function normalizeTalla(string|int|float $talla): string
    {
        return number_format((float) $talla, 1, '.', '');
    }
}
