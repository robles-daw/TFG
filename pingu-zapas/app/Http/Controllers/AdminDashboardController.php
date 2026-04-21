<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Noticia;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Zapatilla;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'ventas' => Pedido::sum('total'),
            'pedidos' => Pedido::count(),
            'usuarios' => User::count(),
            'productos' => Zapatilla::count(),
            'categorias' => Categoria::count(),
            'noticias' => Noticia::count(),
        ];

        $ultimosPedidos = Pedido::with('user')->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'ultimosPedidos'));
    }
}
