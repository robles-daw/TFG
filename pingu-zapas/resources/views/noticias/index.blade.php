@extends('layout.master')

@section('title', 'Noticias | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Noticias</h1>
                <p class="page-subtitle">Blog básico para lanzamientos, ofertas y contenido general.</p>
            </div>
        </div>
        <div class="news-grid">
            @foreach($noticias as $noticia)
                <a class="news-card" href="{{ route('noticias.show', $noticia->slug) }}">
                    <div class="news-cover"><img src="{{ $noticia->image_url }}" alt="{{ $noticia->titulo }}"></div>
                    <span class="badge">{{ ucfirst($noticia->categoria) }}</span>
                    <h3>{{ $noticia->titulo }}</h3>
                    <p class="muted">{{ $noticia->resumen }}</p>
                    <small class="muted">Por {{ $noticia->autor->name }} · {{ optional($noticia->publicado_en)->format('d/m/Y') }}</small>
                </a>
            @endforeach
        </div>
        <div class="pagination">{{ $noticias->links() }}</div>
    </div>
@endsection
