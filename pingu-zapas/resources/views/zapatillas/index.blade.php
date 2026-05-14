@extends('layout.master')

@section('title', 'Catálogo | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Catálogo</h1>
                <p class="page-subtitle">Filtra nuestra selección y encuentra el par que encaja con tu estilo, talla y presupuesto.</p>
            </div>
        </div>

        <div class="catalog-layout">
            <aside class="panel sidebar">
                <form method="GET" class="filters-form" style="display: grid; gap: 24px;">
                    <div>
                        <h3 style="font-size: 1.1rem; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-search" style="color: var(--accent);"></i> Buscar
                        </h3>
                        <div class="field">
                            <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por marca, modelo o nombre" style="background: rgba(255,255,255,0.03);">
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
                            <i class="fas fa-sliders-h" style="color: var(--accent);"></i> Talla y precio
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
                                <input id="precio_min" type="number" step="0.01" name="precio_min" value="{{ request('precio_min', floor($precioMin)) }}" placeholder="Precio mínimo">
                            </div>
                            <div class="field">
                                <input id="precio_max" type="number" step="0.01" name="precio_max" value="{{ request('precio_max', ceil($precioMax)) }}" placeholder="Precio máximo">
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; gap: 10px;">
                        <button class="btn btn-primary" type="submit" style="width: 100%;">Aplicar filtros</button>
                        <a href="{{ route('zapatillas.index') }}" class="btn btn-ghost" style="width: 100%;">Borrar filtros</a>
                    </div>
                </form>
            </aside>

            <div>
                <div class="product-grid">
                    @forelse($zapatillas as $zapatilla)
                        <a class="product-card" href="{{ route('zapatillas.show', $zapatilla) }}" style="padding: 14px; transition: 0.3s ease;">
                            <div class="product-image">
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
                            <h3>No hemos encontrado resultados</h3>
                            <p class="muted">Prueba a modificar la búsqueda o a ampliar los filtros seleccionados.</p>
                        </div>
                    @endforelse
                </div>

                {{ $zapatillas->links() }}
            </div>
        </div>
    </div>
@endsection
