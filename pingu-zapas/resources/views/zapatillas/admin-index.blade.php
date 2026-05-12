@extends('layout.master')

@section('title', 'Admin zapatillas | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Gestion de zapatillas</h1>
                <p class="page-subtitle">Gestiona el catálogo de productos y el stock disponible.</p>
            </div>
            <a href="{{ route('admin.zapatillas.create') }}" class="btn btn-primary">Nueva zapatilla</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($zapatillas as $zapatilla)
                        <tr>
                            <td>
                                <div style="display: flex; gap: 12px; align-items: center;">
                                    <img src="{{ $zapatilla->main_image_url }}" class="admin-thumb">
                                    <div>
                                        <strong>{{ $zapatilla->nombre }}</strong><br>
                                        <small class="muted">{{ $zapatilla->marca }} {{ $zapatilla->modelo }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $zapatilla->categoria->nombre }}</td>
                            <td><strong>{{ number_format($zapatilla->precio, 2) }} €</strong></td>
                            <td>
                                <span class="badge {{ $zapatilla->activo ? 'badge-success' : 'badge-warning' }}">
                                    {{ $zapatilla->activo ? 'Activo' : 'Oculto' }}
                                </span>
                                @if($zapatilla->destacado)
                                    <span class="badge" style="background: rgba(255, 107, 53, 0.1); color: var(--accent);">🔥 Destacado</span>
                                @endif
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.zapatillas.edit', $zapatilla) }}" class="btn btn-ghost" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.zapatillas.destroy', $zapatilla) }}" onsubmit="return confirm('¿Estás seguro?')">
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
        {{ $zapatillas->links() }}
    </div>
@endsection
