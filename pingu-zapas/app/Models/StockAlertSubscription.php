<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAlertSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'zapatilla_id',
        'talla',
        'email',
    ];

    protected function casts(): array
    {
        return [
            'talla' => 'decimal:1',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zapatilla()
    {
        return $this->belongsTo(Zapatilla::class);
    }
}
