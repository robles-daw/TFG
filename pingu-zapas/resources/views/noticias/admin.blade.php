@extends('layout.master')

@section('title', 'Admin noticias | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Gestion de noticias</h1>
            <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary">Nueva noticia</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Categoria</th>
                        <th>Estado</th>
                        <th>Autor</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($noticias as $noticia)
                        <tr>
                            <td>
                                <div style="display: flex; gap: 12px; align-items: center;">
                                    <img src="{{ $noticia->image_url }}" class="admin-thumb">
                                    <strong>{{ Str::limit($noticia->titulo, 40) }}</strong>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background: rgba(46, 196, 182, 0.1); color: var(--accent-2);">
                                    {{ ucfirst($noticia->categoria) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $noticia->publicado ? 'badge-success' : 'badge-warning' }}">
                                    {{ $noticia->publicado ? 'Publicada' : 'Borrador' }}
                                </span>
                            </td>
                            <td><span class="muted">{{ $noticia->autor->name }}</span></td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.noticias.edit', $noticia) }}" class="btn btn-ghost" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.noticias.destroy', $noticia) }}" onsubmit="return confirm('¿Estás seguro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-ghost" type="submit" title="Eliminar" style="color: var(--danger);">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $noticias->links() }}</div>
    </div>
@endsection
