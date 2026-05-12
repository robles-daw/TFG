@extends('layout.master')

@section('title', $noticia->titulo . ' | Pingu Zapas')

@section('content')
    <div class="container">
        <article class="panel article-panel">
            <div class="news-cover-detail"
                 style="background-image: url('{{ $noticia->image_url }}');">
            </div>
            <span class="badge">
                {{ ucfirst($noticia->categoria) }}
            </span>
            <h1 class="page-title">
                {{ $noticia->titulo }}
            </h1>
            <p class="page-subtitle">
                {{ $noticia->resumen }}
            </p>
            <p class="muted">
                Publicado por {{ $noticia->autor->name }}
                el {{ $noticia->publicado_en?->format('d/m/Y') }}
            </p>
            <div class="news-body">
                {!! $noticia->contenido !!}
            </div>
        </article>

        @if($relacionadas->isNotEmpty())
            <section class="section">
                <h2 class="related-title">Relacionadas</h2>
                <div class="news-grid">
                    @foreach($relacionadas as $item)
                        <a class="news-card"
                           href="{{ route('noticias.show', $item->slug) }}">
                            <div class="news-cover">
                                <img src="{{ $item->image_url }}" alt="{{ $item->titulo }}">
                            </div>
                            <div class="news-card-content">
                                <span class="badge related-badge">
                                    {{ ucfirst($item->categoria) }}
                                </span>
                                <h3 class="related-card-title">{{ $item->titulo }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
@push('styles')
    <style>
        .article-panel {
            padding: 24px;
        }
        .news-cover-detail {
            width: 100%;
            height: 600px;
            margin-bottom: 24px;
            overflow: hidden;
            border-radius: 18px;

            background-color: #0c1620;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .related-title {
            font-size: 2rem;
        }
        .related-badge {
            margin-bottom: 8px;
        }
        .related-card-title {
            margin-top: 0;
            font-size: 1.1rem;
        }
        .news-body {
            line-height: 1.8;
        }
        .news-body > *:first-child {
            margin-top: 0;
        }
        .news-body > *:last-child {
            margin-bottom: 0;
        }
        .news-body p,
        .news-body ul,
        .news-body ol,
        .news-body blockquote,
        .news-body h1,
        .news-body h2,
        .news-body h3,
        .news-body h4 {
            margin-bottom: 1rem;
        }
        .news-body ul,
        .news-body ol {
            padding-left: 1.5rem;
        }
        .news-body a {
            color: var(--accent);
        }
        .news-body blockquote {
            margin-left: 0;
            padding-left: 1rem;
            border-left: 3px solid var(--accent);
            color: var(--muted);
        }
    </style>
@endpush
