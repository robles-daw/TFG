@extends('layout.master')

@section('title', $noticia->titulo . ' | Pingu Zapas')

@section('content')
    <div class="container">
        <article class="panel" style="padding: 24px;">
            <div class="news-cover" style="height: 340px;">
                <img src="{{ $noticia->image_url }}" alt="{{ $noticia->titulo }}">
            </div>
            <span class="badge">{{ ucfirst($noticia->categoria) }}</span>
            <h1 class="page-title">{{ $noticia->titulo }}</h1>
            <p class="page-subtitle">{{ $noticia->resumen }}</p>
            <p class="muted">Publicado por {{ $noticia->autor->name }} el {{ optional($noticia->publicado_en)->format('d/m/Y') }}</p>
            <div style="white-space: pre-line; line-height: 1.8;">{{ $noticia->contenido }}</div>
        </article>

        @if($relacionadas->isNotEmpty())
            <section class="section">
                <h2 class="page-title" style="font-size: 2rem;">Relacionadas</h2>
                <div class="news-grid">
                    @foreach($relacionadas as $item)
                        <a class="news-card" href="{{ route('noticias.show', $item->slug) }}">
                            <div class="news-cover"><img src="{{ $item->image_url }}" alt="{{ $item->titulo }}"></div>
                            <h3>{{ $item->titulo }}</h3>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
