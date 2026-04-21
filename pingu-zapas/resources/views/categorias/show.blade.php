@extends('layout.master')

@section('title', $categoria->nombre . ' | Pingu Zapas')

@section('content')
    <div class="container">
        <section class="panel" style="padding: 24px;">
            <div class="detail-layout">
                <div class="category-cover" style="height: 320px; margin-bottom: 0;">
                    <img src="{{ $categoria->image_url }}" alt="{{ $categoria->nombre }}">
                </div>
                <div>
                    <span class="badge">Categoria</span>
                    <h1 class="page-title">{{ $categoria->nombre }}</h1>
                    <p class="page-subtitle">{{ $categoria->descripcion }}</p>
                    <a href="{{ route('zapatillas.index', ['categoria' => $categoria->slug]) }}" class="btn btn-primary">Ver productos</a>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="product-grid">
                @forelse($categoria->zapatillas as $zapatilla)
                    <a class="product-card" href="{{ route('zapatillas.show', $zapatilla) }}">
                        <div class="product-image">
                            <img src="{{ $zapatilla->main_image_url }}" alt="{{ $zapatilla->nombre }}">
                        </div>
                        <h3>{{ $zapatilla->nombre }}</h3>
                        <p class="muted">{{ number_format($zapatilla->precio, 2) }} €</p>
                    </a>
                @empty
                    <div class="panel" style="padding: 24px;">No hay productos activos en esta categoria.</div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
