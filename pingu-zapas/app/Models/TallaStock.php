<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TallaStock extends Model
{
    use HasFactory;

    protected $table = 'tallas_stock';

    protected $fillable = [
        'zapatilla_id',
        'talla',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'talla' => 'decimal:1',
            'stock' => 'integer',
        ];
    }

    public function zapatilla()
    {
        return $this->belongsTo(Zapatilla::class);
    }

    public function stockAlertSubscriptions()
    {
        return $this->hasMany(StockAlertSubscription::class, 'zapatilla_id', 'zapatilla_id')
            ->where('talla', $this->talla);
    }
}
