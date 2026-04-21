<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'imagen',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!$this->imagen) {
            return asset('img/no-image.png');
        }

        if (filter_var($this->imagen, FILTER_VALIDATE_URL)) {
            return $this->imagen;
        }

        return asset('storage/' . $this->imagen);
    }

    public function zapatillas()
    {
        return $this->hasMany(Zapatilla::class);
    }
}
