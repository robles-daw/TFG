@extends('layout.master')

@section('title', 'Pingu Zapas | Inicio')

@section('content')
    <div class="container">
        <section class="hero">
            <div>
                <h1>Sneakers seleccionadas para moverte con estilo.</h1>
                <p>Descubre una selección cuidada de calzado urbano y deportivo: modelos actuales, comodidad diaria y lanzamientos pensados para destacar.</p>
                <div class="hero-actions">
                    <a href="{{ route('zapatillas.index') }}" class="btn btn-primary">Ver catálogo</a>
                    <a href="{{ route('categorias.index') }}" class="btn btn-ghost">Explorar categorías</a>
                </div>
            </div>
            <div class="hero-image" style="background: url('{{ asset('img/fondoDurisimo.png') }}') no-repeat center center; background-size: cover; display: flex; align-items: center; justify-content: center; padding: 40px; border-radius: 24px; overflow: hidden; position: relative;">
                <div style="position: absolute; inset: 0; background: rgba(8, 16, 25, 0.45);"></div>
                <img src="{{ asset('img/logoZapas.png') }}" alt="Pingu Zapas Hero" style="width: 80%; height: 80%; object-fit: contain; position: relative; z-index: 1; filter: drop-shadow(0 0 40px rgba(0,0,0,0.6)) brightness(1.2);">
            </div>
        </section>

        <section class="section">
            <div class="page-header">
                <div>
                    <h2 class="page-title">Compra por categoría</h2>
                    <p class="page-subtitle">Encuentra rápidamente el tipo de zapatilla que encaja con tu forma de vestir, entrenar o moverte.</p>
                </div>
            </div>
            <div class="cards-grid">
                @foreach($categorias as $categoria)
                    <a class="category-card" href="{{ route('zapatillas.index', ['categoria' => $categoria->slug]) }}">
                        <div class="category-cover">
                            <img src="{{ $categoria->image_url }}" alt="{{ $categoria->nombre }}">
                        </div>
                        <strong>{{ $categoria->nombre }}</strong>
                        <p class="muted">{{ $categoria->descripcion }}</p>
                        <span class="badge">{{ $categoria->zapatillas_count }} productos</span>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="section">
            <div class="page-header">
                <div>
                    <h2 class="page-title">Modelos destacados</h2>
                    <p class="page-subtitle">Una selección de novedades y favoritos elegidos por su diseño, versatilidad y demanda.</p>
                </div>
                <a href="{{ route('zapatillas.index') }}" class="btn btn-ghost">Ver catálogo completo</a>
            </div>
            <div class="product-grid">
                @foreach($destacadas as $zapatilla)
                    <a class="product-card" href="{{ route('zapatillas.show', $zapatilla) }}">
                        <div class="product-image">
                            <img src="{{ $zapatilla->main_image_url }}" alt="{{ $zapatilla->nombre }}">
                            @if($zapatilla->tallasStock->where('stock', '>', 0)->isEmpty())
                                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 2;">
                                    <span style="background: white; color: black; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 0.7rem; letter-spacing: 1px;">SIN STOCK</span>
                                </div>
                            @endif
                        </div>
                        <span class="badge">{{ $zapatilla->categoria->nombre }}</span>
                        <h3>{{ $zapatilla->nombre }}</h3>
                        <p class="muted">{{ $zapatilla->marca }} {{ $zapatilla->modelo }}</p>
                        <strong>{{ number_format($zapatilla->precio, 2) }} €</strong>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="section">
            <div class="page-header">
                <div>
                    <h2 class="page-title">Actualidad sneaker</h2>
                    <p class="page-subtitle">Lanzamientos, tendencias y consejos para elegir mejor tu próximo par.</p>
                </div>
            </div>
            <div class="news-grid">
                @foreach($noticias as $noticia)
                    <a class="news-card" href="{{ route('noticias.show', $noticia->slug) }}">
                        <div class="news-cover" style="background-image: url('{{ $noticia->image_url }}');">
                            <img src="{{ $noticia->image_url }}" alt="{{ $noticia->titulo }}">
                        </div>
                        <div class="news-card-content">
                            <span class="badge" style="margin-bottom: 12px;">{{ ucfirst($noticia->categoria) }}</span>
                            <h3 style="margin-top: 0;">{{ $noticia->titulo }}</h3>
                            <p class="muted" style="margin-bottom: 0;">{{ $noticia->resumen }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
@endsection
