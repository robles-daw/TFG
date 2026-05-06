<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zapatilla extends Model
{
    use HasFactory;

    protected $table = 'zapatillas';

    protected $fillable = [
        'categoria_id',
        'nombre',
        'slug',
        'descripcion',
        'marca',
        'modelo',
        'precio',
        'imagen_principal',
        'imagenes_extra',
        'activo',
        'destacado',
    ];

    protected function casts(): array
    {
        return [
            'imagenes_extra' => 'array',
            'precio' => 'decimal:2',
            'activo' => 'boolean',
            'destacado' => 'boolean',
        ];
    }

    public function getMainImageUrlAttribute(): string
    {
        if (!$this->imagen_principal) {
            return asset('img/no-image.png');
        }

        if (filter_var($this->imagen_principal, FILTER_VALIDATE_URL)) {
            return $this->imagen_principal;
        }

        return asset('storage/' . $this->imagen_principal);
    }

    public function getExtraImageUrlsAttribute(): array
    {
        return collect($this->imagenes_extra ?? [])->map(function ($img) {
            if (filter_var($img, FILTER_VALIDATE_URL)) {
                return $img;
            }
            return asset('storage/' . $img);
        })->toArray();
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tallasStock()
    {
        return $this->hasMany(TallaStock::class, 'zapatilla_id');
    }

    public function pedidoItems()
    {
        return $this->hasMany(PedidoItem::class, 'zapatilla_id');
    }

    public function stockAlertSubscriptions()
    {
        return $this->hasMany(StockAlertSubscription::class, 'zapatilla_id');
    }
}
