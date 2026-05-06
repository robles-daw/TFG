<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\StockAlertSubscription;
use App\Models\Zapatilla;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ZapatillaController extends Controller
{
    public function index(Request $request): View
    {
        if ($request->routeIs('admin.*')) {
            $zapatillas = Zapatilla::with(['categoria', 'tallasStock'])->latest()->paginate(12);

            return view('zapatillas.admin-index', compact('zapatillas'));
        }

        $baseQuery = Zapatilla::query()->where('activo', true);

        $categorias = Categoria::withCount(['zapatillas' => fn ($query) => $query->where('activo', true)])
            ->orderBy('nombre')
            ->get();

        $marcas = Zapatilla::where('activo', true)
            ->whereNotNull('marca')
            ->select('marca')
            ->distinct()
            ->orderBy('marca')
            ->pluck('marca');

        $tallas = Zapatilla::where('activo', true)
            ->join('tallas_stock', 'tallas_stock.zapatilla_id', '=', 'zapatillas.id')
            ->where('tallas_stock.stock', '>', 0)
            ->select('tallas_stock.talla')
            ->distinct()
            ->orderBy('tallas_stock.talla')
            ->pluck('talla');

        $precioMin = (float) ($baseQuery->min('precio') ?? 0);
        $precioMax = (float) ($baseQuery->max('precio') ?? 0);

        $query = Zapatilla::with(['categoria', 'tallasStock'])
            ->where('activo', true)
            ->when($request->filled('q'), fn (Builder $builder) => $builder->where(function (Builder $nested) use ($request) {
                $term = $request->string('q')->toString();
                $nested->where('nombre', 'like', "%{$term}%")
                    ->orWhere('marca', 'like', "%{$term}%")
                    ->orWhere('modelo', 'like', "%{$term}%");
            }))
            ->when($request->filled('categoria'), function (Builder $builder) use ($request) {
                $builder->whereHas('categoria', fn (Builder $query) => $query->where('slug', $request->categoria));
            })
            ->when($request->filled('marca'), fn (Builder $builder) => $builder->where('marca', $request->marca))
            ->when($request->filled('talla'), fn (Builder $builder) => $builder->whereHas('tallasStock', fn (Builder $query) => $query
                ->where('talla', $request->talla)
                ->where('stock', '>', 0)))
            ->when($request->filled('precio_min'), fn (Builder $builder) => $builder->where('precio', '>=', $request->precio_min))
            ->when($request->filled('precio_max'), fn (Builder $builder) => $builder->where('precio', '<=', $request->precio_max));

        match ($request->get('orden')) {
            'precio_desc' => $query->orderByDesc('precio'),
            'nombre' => $query->orderBy('nombre'),
            default => $query->orderByDesc('destacado')->latest(),
        };

        $zapatillas = $query->paginate(9)->withQueryString();

        return view('zapatillas.index', compact(
            'zapatillas',
            'categorias',
            'marcas',
            'tallas',
            'precioMin',
            'precioMax'
        ));
    }

    public function create(): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('zapatillas.create', compact('categorias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:150',
            'precio' => 'required|numeric|min:0',
            'imagen_principal' => 'nullable|string|max:255',
            'imagen_principal_file' => 'nullable|image|max:2048',
            'imagenes_extra' => 'nullable|string',
            'imagenes_extra_files.*' => 'nullable|image|max:2048',
        ]);

        $mainImage = $request->input('imagen_principal');
        if ($request->hasFile('imagen_principal_file')) {
            $mainImage = $request->file('imagen_principal_file')->store('zapatillas', 'public');
        }

        $extraImages = $this->parseImages($request->input('imagenes_extra'));
        if ($request->hasFile('imagenes_extra_files')) {
            foreach ($request->file('imagenes_extra_files') as $file) {
                $extraImages[] = $file->store('zapatillas', 'public');
            }
        }

        $zapatilla = Zapatilla::create([
            'categoria_id' => $data['categoria_id'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'marca' => $data['marca'],
            'modelo' => $data['modelo'],
            'precio' => $data['precio'],
            'slug' => Str::slug($data['nombre']) . '-' . Str::lower(Str::random(6)),
            'imagen_principal' => $mainImage,
            'imagenes_extra' => $extraImages,
            'activo' => $request->boolean('activo', true),
            'destacado' => $request->boolean('destacado'),
        ]);

        return redirect()->route('admin.zapatillas.edit', $zapatilla)->with('success', 'Zapatilla creada correctamente.');
    }

    public function show(Zapatilla $zapatilla): View
    {
        $zapatilla->load(['categoria', 'tallasStock']);
        $subscribedSizes = [];

        if (Auth::check()) {
            $subscribedSizes = StockAlertSubscription::where('user_id', Auth::id())
                ->where('zapatilla_id', $zapatilla->id)
                ->pluck('talla')
                ->map(fn ($talla) => number_format((float) $talla, 1, '.', ''))
                ->all();
        }

        $relacionadas = Zapatilla::with('categoria')
            ->where('activo', true)
            ->where('categoria_id', $zapatilla->categoria_id)
            ->whereKeyNot($zapatilla->id)
            ->take(4)
            ->get();

        return view('zapatillas.show', compact('zapatilla', 'relacionadas', 'subscribedSizes'));
    }

    public function edit(Zapatilla $zapatilla): View
    {
        $zapatilla->load('tallasStock');
        $categorias = Categoria::orderBy('nombre')->get();

        return view('zapatillas.edit', compact('zapatilla', 'categorias'));
    }

    public function update(Request $request, Zapatilla $zapatilla): RedirectResponse
    {
        $data = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:150',
            'precio' => 'required|numeric|min:0',
            'imagen_principal' => 'nullable|string|max:255',
            'imagen_principal_file' => 'nullable|image|max:2048',
            'imagenes_extra' => 'nullable|string',
            'imagenes_extra_files.*' => 'nullable|image|max:2048',
        ]);

        $mainImage = $request->input('imagen_principal', $zapatilla->imagen_principal);
        if ($request->hasFile('imagen_principal_file')) {
            if ($zapatilla->imagen_principal && ! filter_var($zapatilla->imagen_principal, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($zapatilla->imagen_principal);
            }
            $mainImage = $request->file('imagen_principal_file')->store('zapatillas', 'public');
        }

        $extraImages = $this->parseImages($request->input('imagenes_extra'));
        if ($request->hasFile('imagenes_extra_files')) {
            foreach ($request->file('imagenes_extra_files') as $file) {
                $extraImages[] = $file->store('zapatillas', 'public');
            }
        }

        $zapatilla->update([
            'categoria_id' => $data['categoria_id'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'marca' => $data['marca'],
            'modelo' => $data['modelo'],
            'precio' => $data['precio'],
            'imagen_principal' => $mainImage,
            'imagenes_extra' => $extraImages,
            'activo' => $request->boolean('activo'),
            'destacado' => $request->boolean('destacado'),
        ]);

        return redirect()->route('admin.zapatillas.edit', $zapatilla)->with('success', 'Zapatilla actualizada correctamente.');
    }

    public function destroy(Zapatilla $zapatilla): RedirectResponse
    {
        if ($zapatilla->imagen_principal && ! filter_var($zapatilla->imagen_principal, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($zapatilla->imagen_principal);
        }

        foreach ($zapatilla->imagenes_extra ?? [] as $img) {
            if (! filter_var($img, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($img);
            }
        }

        $zapatilla->delete();

        return redirect()->route('admin.zapatillas.index')->with('success', 'Zapatilla eliminada correctamente.');
    }

    private function parseImages(?string $value): array
    {
        if (! $value) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $value))
            ->map(fn ($image) => trim((string) $image))
            ->filter()
            ->values()
            ->all();
    }
}
