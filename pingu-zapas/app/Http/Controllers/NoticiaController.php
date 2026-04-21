<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NoticiaController extends Controller
{
    public function index(): View
    {
        $noticias = Noticia::with('autor')
            ->where('publicado', true)
            ->latest('publicado_en')
            ->paginate(9);

        return view('noticias.index', compact('noticias'));
    }

    public function backendIndex(): View
    {
        $noticias = Noticia::with('autor')->latest()->paginate(12);

        return view('noticias.admin', compact('noticias'));
    }

    public function create(): View
    {
        return view('noticias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'resumen' => 'nullable|string',
            'contenido' => 'required|string',
            'imagen_portada' => 'nullable|string|max:255',
            'imagen_portada_file' => 'nullable|image|max:2048',
            'categoria' => 'required|in:lanzamiento,oferta,evento,general',
        ]);

        $image = $request->input('imagen_portada');
        if ($request->hasFile('imagen_portada_file')) {
            $image = $request->file('imagen_portada_file')->store('noticias', 'public');
        }

        Noticia::create([
            'user_id' => Auth::id(),
            'titulo' => $data['titulo'],
            'resumen' => $data['resumen'],
            'contenido' => $data['contenido'],
            'categoria' => $data['categoria'],
            'slug' => Str::slug($data['titulo']) . '-' . Str::lower(Str::random(6)),
            'imagen_portada' => $image,
            'publicado' => $request->boolean('publicado'),
            'publicado_en' => $request->boolean('publicado') ? now() : null,
            'destacado' => $request->boolean('destacado'),
        ]);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia creada correctamente.');
    }

    public function show(string $slug): View
    {
        $noticia = Noticia::with('autor')
            ->where('slug', $slug)
            ->where('publicado', true)
            ->firstOrFail();

        $relacionadas = Noticia::where('publicado', true)
            ->where('categoria', $noticia->categoria)
            ->whereKeyNot($noticia->id)
            ->latest('publicado_en')
            ->take(3)
            ->get();

        return view('noticias.show', compact('noticia', 'relacionadas'));
    }

    public function edit(Noticia $noticia): View
    {
        return view('noticias.edit', compact('noticia'));
    }

    public function update(Request $request, Noticia $noticia): RedirectResponse
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'resumen' => 'nullable|string',
            'contenido' => 'required|string',
            'imagen_portada' => 'nullable|string|max:255',
            'imagen_portada_file' => 'nullable|image|max:2048',
            'categoria' => 'required|in:lanzamiento,oferta,evento,general',
        ]);

        $image = $request->input('imagen_portada', $noticia->imagen_portada);
        if ($request->hasFile('imagen_portada_file')) {
            if ($noticia->imagen_portada && !filter_var($noticia->imagen_portada, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($noticia->imagen_portada);
            }
            $image = $request->file('imagen_portada_file')->store('noticias', 'public');
        }

        $shouldPublish = $request->boolean('publicado');

        $noticia->update([
            'titulo' => $data['titulo'],
            'resumen' => $data['resumen'],
            'contenido' => $data['contenido'],
            'categoria' => $data['categoria'],
            'imagen_portada' => $image,
            'publicado' => $shouldPublish,
            'publicado_en' => $shouldPublish ? ($noticia->publicado_en ?? now()) : null,
            'destacado' => $request->boolean('destacado'),
        ]);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy(Noticia $noticia): RedirectResponse
    {
        if ($noticia->imagen_portada && !filter_var($noticia->imagen_portada, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($noticia->imagen_portada);
        }

        $noticia->delete();

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia eliminada correctamente.');
    }
}
