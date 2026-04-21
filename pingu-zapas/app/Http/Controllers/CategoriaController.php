<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(Request $request): View
    {
        $categorias = Categoria::withCount(['zapatillas' => fn ($query) => $query->where('activo', true)])
            ->orderBy('nombre')
            ->paginate($request->routeIs('admin.*') ? 12 : 24);

        $view = $request->routeIs('admin.*') ? 'categorias.admin-index' : 'categorias.index';

        return view($view, compact('categorias'));
    }

    public function create(): View
    {
        return view('categorias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|string|max:255',
            'imagen_file' => 'nullable|image|max:2048',
        ]);

        $image = $request->input('imagen');
        if ($request->hasFile('imagen_file')) {
            $image = $request->file('imagen_file')->store('categorias', 'public');
        }

        Categoria::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'imagen' => $image,
            'slug' => Str::slug($data['nombre']),
        ]);

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function show(Categoria $categoria): View
    {
        $categoria->load([
            'zapatillas' => fn ($query) => $query->where('activo', true)->latest(),
        ]);

        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria): View
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|string|max:255',
            'imagen_file' => 'nullable|image|max:2048',
        ]);

        $image = $request->input('imagen', $categoria->imagen);
        if ($request->hasFile('imagen_file')) {
            if ($categoria->imagen && !filter_var($categoria->imagen, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($categoria->imagen);
            }
            $image = $request->file('imagen_file')->store('categorias', 'public');
        }

        $categoria->update([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'imagen' => $image,
            'slug' => Str::slug($data['nombre']),
        ]);

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        if ($categoria->imagen && !filter_var($categoria->imagen, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($categoria->imagen);
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
