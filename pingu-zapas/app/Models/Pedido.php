<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'descuento_id',
        'numero_pedido',
        'estado',
        'subtotal',
        'descuento_aplicado',
        'gastos_envio',
        'total',
        'nombre_envio',
        'direccion_envio',
        'ciudad_envio',
        'codigo_postal_envio',
        'pais_envio',
        'telefono_contacto',
        'metodo_pago',
        'referencia_pago',
        'notas',
        'fecha_envio',
        'fecha_entrega',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'descuento_aplicado' => 'decimal:2',
            'gastos_envio' => 'decimal:2',
            'total' => 'decimal:2',
            'fecha_envio' => 'datetime',
            'fecha_entrega' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function descuento()
    {
        return $this->belongsTo(Descuento::class);
    }

    public function items()
    {
        return $this->hasMany(PedidoItem::class);
    }
}
