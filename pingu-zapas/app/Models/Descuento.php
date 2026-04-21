<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descripcion',
        'tipo',
        'valor',
        'minimo_pedido',
        'maximo_descuento',
        'usos_maximos',
        'usos_actuales',
        'activo',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'minimo_pedido' => 'decimal:2',
            'maximo_descuento' => 'decimal:2',
            'usos_maximos' => 'integer',
            'usos_actuales' => 'integer',
            'activo' => 'boolean',
            'fecha_inicio' => 'datetime',
            'fecha_fin' => 'datetime',
        ];
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function isValidForSubtotal($subtotal): bool
    {
        if (!$this->activo) return false;

        $now = now();
        if ($this->fecha_inicio && $now->lt($this->fecha_inicio)) return false;
        if ($this->fecha_fin && $now->gt($this->fecha_fin)) return false;

        if ($this->usos_maximos && $this->usos_actuales >= $this->usos_maximos) return false;

        if ($this->minimo_pedido && $subtotal < $this->minimo_pedido) return false;

        return true;
    }

    public function calculateDiscount($subtotal): float
    {
        $discount = 0;

        if ($this->tipo === 'porcentaje') {
            $discount = $subtotal * ($this->valor / 100);
            if ($this->maximo_descuento && $discount > $this->maximo_descuento) {
                $discount = $this->maximo_descuento;
            }
        } else {
            $discount = $this->valor;
        }

        // El descuento no puede ser mayor que el subtotal
        return min($discount, $subtotal);
    }
}
