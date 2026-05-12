<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = Auth::user()->load([
            'pedidos' => fn ($query) => $query->with('items.zapatilla')->latest(),
        ]);

        return view('perfil.index', compact('user'));
    }

    public function edit(): View
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'codigo_postal' => 'nullable|string|max:20',
            'pais' => 'nullable|string|max:255',
        ]);

        $user->update($request->all());

        return redirect()->route('perfil.index')->with('success', 'Perfil actualizado correctamente.');
    }
}
