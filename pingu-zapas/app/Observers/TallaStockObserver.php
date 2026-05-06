<?php

namespace App\Observers;

use App\Mail\StockAvailableMail;
use App\Models\StockAlertSubscription;
use App\Models\TallaStock;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class TallaStockObserver
{
    public function saved(TallaStock $tallaStock): void
    {
        $previousStock = $tallaStock->wasRecentlyCreated
            ? 0
            : (int) $tallaStock->getOriginal('stock');

        $currentStock = (int) $tallaStock->stock;

        if ($previousStock > 0 || $currentStock <= 0) {
            return;
        }

        $subscriptions = StockAlertSubscription::with(['user', 'zapatilla'])
            ->where('zapatilla_id', $tallaStock->zapatilla_id)
            ->where(function ($query) use ($tallaStock) {
                $query->where('talla', $tallaStock->talla)
                      ->orWhere('talla', 0);
            })
            ->get();

        foreach ($subscriptions as $subscription) {
            try {
                Mail::to($subscription->email)->send(new StockAvailableMail($subscription, $tallaStock));
                $subscription->delete();
            } catch (Throwable $exception) {
                Log::warning('No se pudo enviar el aviso de reposicion de stock.', [
                    'subscription_id' => $subscription->id,
                    'zapatilla_id' => $tallaStock->zapatilla_id,
                    'talla' => $tallaStock->talla,
                    'error' => $exception->getMessage(),
                ]);
            }
        }
    }
}
