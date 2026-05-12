@extends('layout.master')

@section('title', 'Catalogo | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Catalogo</h1>
                <p class="page-subtitle">Encuentra el par perfecto entre nuestra selección exclusiva.</p>
            </div>
        </div>

        <div class="catalog-layout">
            <aside class="panel sidebar" style="padding: 24px; border-radius: 24px; height: fit-content; position: sticky; top: 100px;">
                <form method="GET" class="filters-form" style="display: grid; gap: 24px;">
                    <div>
                        <h3 style="font-size: 1.1rem; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-search" style="color: var(--accent);"></i> Buscar
                        </h3>
                        <div class="field">
                            <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Marca, nombre..." style="background: rgba(255,255,255,0.03);">
                        </div>
                    </div>

                    <div>
                        <h3 style="font-size: 1.1rem; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-filter" style="color: var(--accent);"></i> Categoría
                        </h3>
                        <div class="field">
                            <select id="categoria" name="categoria">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->slug }}" @selected(request('categoria') === $categoria->slug)>
                                        {{ $categoria->nombre }} ({{ $categoria->zapatillas_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <h3 style="font-size: 1.1rem; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-sliders-h" style="color: var(--accent);"></i> Talla y Precio
                        </h3>
                        <div class="field" style="margin-bottom: 12px;">
                            <select id="talla" name="talla">
                                <option value="">Cualquier talla</option>
                                @foreach($tallas as $talla)
                                    <option value="{{ $talla }}" @selected((string) request('talla') === (string) $talla)>Talla {{ $talla }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid-2">
                            <div class="field">
                                <input id="precio_min" type="number" step="0.01" name="precio_min" value="{{ request('precio_min', floor($precioMin)) }}" placeholder="Min">
                            </div>
                            <div class="field">
                                <input id="precio_max" type="number" step="0.01" name="precio_max" value="{{ request('precio_max', ceil($precioMax)) }}" placeholder="Max">
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; gap: 10px;">
                        <button class="btn btn-primary" type="submit" style="width: 100%;">Filtrar Resultados</button>
                        <a href="{{ route('zapatillas.index') }}" class="btn btn-ghost" style="width: 100%;">Limpiar</a>
                    </div>
                </form>
            </aside>

            <div>
                <div class="product-grid">
                    @forelse($zapatillas as $zapatilla)
                        <a class="product-card" href="{{ route('zapatillas.show', $zapatilla) }}" style="padding: 14px; transition: 0.3s ease;">
                            <div class="product-image" style="height: 240px; border-radius: 18px; overflow: hidden; margin-bottom: 16px; position: relative;">
                                <img src="{{ $zapatilla->main_image_url }}" alt="{{ $zapatilla->nombre }}" style="transition: transform 0.5s ease;">
                                @if($zapatilla->destacado)
                                    <span style="position: absolute; top: 12px; right: 12px; background: var(--accent); color: white; padding: 4px 10px; border-radius: 99px; font-size: 0.75rem; font-weight: 700;">DESTACADO</span>
                                @endif
                                @if($zapatilla->tallasStock->where('stock', '>', 0)->isEmpty())
                                    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 2;">
                                        <span style="background: white; color: black; padding: 8px 16px; border-radius: 8px; font-weight: 800; font-size: 0.9rem; letter-spacing: 1px;">SIN STOCK</span>
                                    </div>
                                @endif
                            </div>
                            <div style="padding: 0 4px;">
                                <span class="badge" style="font-size: 0.75rem; margin-bottom: 8px;">{{ $zapatilla->categoria->nombre }}</span>
                                <h3 style="margin: 0; font-size: 1.2rem; line-height: 1.2;">{{ $zapatilla->nombre }}</h3>
                                <p class="muted" style="font-size: 0.9rem; margin: 4px 0 16px;">{{ $zapatilla->marca }} · {{ $zapatilla->modelo }}</p>
                                <div class="inline-actions" style="justify-content: space-between; align-items: baseline;">
                                    <span style="font-size: 1.4rem; font-weight: 800;">{{ number_format($zapatilla->precio, 2) }} €</span>
                                    <span class="muted" style="font-size: 0.8rem;">{{ $zapatilla->tallasStock->where('stock', '>', 0)->count() }} tallas</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="panel" style="padding: 48px; text-align: center; grid-column: 1 / -1;">
                            <i class="fas fa-search" style="font-size: 3rem; color: var(--line); margin-bottom: 16px;"></i>
                            <h3>Sin resultados</h3>
                            <p class="muted">Prueba con otra combinación de filtros.</p>
                        </div>
                    @endforelse
                </div>

                <div style="margin-top: 40px;">{{ $zapatillas->links() }}</div>
            </div>
        </div>
    </div>
@endsection
