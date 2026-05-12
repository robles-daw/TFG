@extends('layout.master')

@section('title', 'Categorías | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Categorías</h1>
                <p class="page-subtitle">Explora nuestras colecciones y accede directamente al estilo que estás buscando.</p>
            </div>
        </div>

        <div class="cards-grid">
            @foreach($categorias as $categoria)
                <a class="category-card" href="{{ route('categorias.show', $categoria) }}">
                    <div class="category-cover">
                        <img src="{{ $categoria->image_url }}" alt="{{ $categoria->nombre }}">
                    </div>
                    <h3>{{ $categoria->nombre }}</h3>
                    <p class="muted">{{ $categoria->descripcion }}</p>
                    <span class="badge">{{ $categoria->zapatillas_count }} productos</span>
                </a>
            @endforeach
        </div>

        {{ $categorias->links() }}
    </div>
@endsection
