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
                    <div class="news-cover" style="background-image: url('{{ $noticia->image_url }}');">
                        <img src="{{ $noticia->image_url }}" alt="{{ $noticia->titulo }}">
                    </div>
                    <div class="news-card-content">
                        <span class="badge" style="margin-bottom: 12px;">{{ ucfirst($noticia->categoria) }}</span>
                        <h3 style="margin-top: 0;">{{ $noticia->titulo }}</h3>
                        <p class="muted" style="margin-bottom: 8px;">{{ $noticia->resumen }}</p>
                        <small class="muted">Por {{ $noticia->autor->name }} · {{ optional($noticia->publicado_en)->format('d/m/Y') }}</small>
                    </div>
                </a>
            @endforeach
        </div>
        <div style="margin-top: 40px;">{{ $noticias->links() }}</div>
    </div>
@endsection
