<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'slug',
        'resumen',
        'contenido',
        'imagen_portada',
        'categoria',
        'publicado',
        'publicado_en',
        'destacado',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!$this->imagen_portada) {
            return asset('img/no-image.png');
        }

        if (filter_var($this->imagen_portada, FILTER_VALIDATE_URL)) {
            return $this->imagen_portada;
        }

        return asset('storage/' . $this->imagen_portada);
    }

    protected function casts(): array
    {
        return [
            'publicado' => 'boolean',
            'destacado' => 'boolean',
            'publicado_en' => 'datetime',
        ];
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
