<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'zapatilla_id',
        'talla',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'talla' => 'decimal:1',
            'cantidad' => 'integer',
            'precio_unitario' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function zapatilla()
    {
        return $this->belongsTo(Zapatilla::class);
    }
}
