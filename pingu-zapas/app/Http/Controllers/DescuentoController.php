<?php

namespace App\Http\Controllers;

use App\Models\Descuento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DescuentoController extends Controller
{
    public function index(): View
    {
        $descuentos = Descuento::latest()->paginate(12);

        return view('descuentos.index', compact('descuentos'));
    }

    public function create(): View
    {
        return view('descuentos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:50|unique:descuentos,codigo',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'minimo_pedido' => 'nullable|numeric|min:0',
            'maximo_descuento' => 'nullable|numeric|min:0',
            'usos_maximos' => 'nullable|integer|min:1',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        Descuento::create([
            ...$data,
            'activo' => $request->boolean('activo'),
        ]);

        return redirect()->route('admin.descuentos.index')->with('success', 'Descuento creado correctamente.');
    }

    public function edit(Descuento $descuento): View
    {
        return view('descuentos.edit', compact('descuento'));
    }

    public function update(Request $request, Descuento $descuento): RedirectResponse
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:50|unique:descuentos,codigo,' . $descuento->id,
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'minimo_pedido' => 'nullable|numeric|min:0',
            'maximo_descuento' => 'nullable|numeric|min:0',
            'usos_maximos' => 'nullable|integer|min:1',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $descuento->update([
            ...$data,
            'activo' => $request->boolean('activo'),
        ]);

        return redirect()->route('admin.descuentos.index')->with('success', 'Descuento actualizado correctamente.');
    }

    public function destroy(Descuento $descuento): RedirectResponse
    {
        $descuento->delete();

        return redirect()->route('admin.descuentos.index')->with('success', 'Descuento eliminado correctamente.');
    }
}
