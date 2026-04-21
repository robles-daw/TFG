<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function index(): View
    {
        $pedidos = Pedido::with(['user', 'items'])
            ->latest()
            ->paginate(12);

        return view('pedidos.index', compact('pedidos'));
    }

    public function misPedidos(): View
    {
        $pedidos = Auth::user()
            ->pedidos()
            ->with('items.zapatilla')
            ->latest()
            ->paginate(10);

        return view('pedidos.mis_pedidos', compact('pedidos'));
    }

    public function show(Pedido $pedido): View
    {
        $user = Auth::user();

        if ($user->rol !== 'admin' && $pedido->user_id !== $user->id) {
            abort(403);
        }

        $pedido->load(['items.zapatilla', 'descuento', 'user']);

        return view('pedidos.show', compact('pedido'));
    }

    public function updateEstado(Request $request, Pedido $pedido): RedirectResponse
    {
        $data = $request->validate([
            'estado' => 'required|in:pendiente,confirmado,preparando,enviado,entregado,cancelado',
        ]);

        $pedido->update($data);

        return back()->with('success', 'Estado actualizado correctamente.');
    }
}
