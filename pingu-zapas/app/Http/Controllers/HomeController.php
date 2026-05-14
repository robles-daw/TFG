<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Noticia;
use App\Models\Zapatilla;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $destacadas = Zapatilla::with('categoria')
            ->where('activo', true)
            ->where('destacado', true)
            ->latest()
            ->take(3)
            ->get();

        $categorias = Categoria::withCount(['zapatillas' => fn ($query) => $query->where('activo', true)])
            ->orderByDesc('zapatillas_count')
            ->take(3)
            ->get();

        $noticias = Noticia::where('publicado', true)
            ->latest('publicado_en')
            ->take(3)
            ->get();

        return view('index', compact('destacadas', 'categorias', 'noticias'));
    }
}
