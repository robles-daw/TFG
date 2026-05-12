@extends('layout.master')

@section('title', 'Admin categorias | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Gestion de categorias</h1>
                <p class="page-subtitle">Alta, edicion y control del escaparate.</p>
            </div>
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary">Nueva categoria</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th>Productos</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $categoria)
                        <tr>
                            <td>
                                <div style="display: flex; gap: 12px; align-items: center;">
                                    <img src="{{ $categoria->image_url }}" class="admin-thumb">
                                    <strong>{{ $categoria->nombre }}</strong>
                                </div>
                            </td>
                            <td><code style="background: var(--bg-soft); padding: 4px 8px; border-radius: 6px;">{{ $categoria->slug }}</code></td>
                            <td><span class="badge">{{ $categoria->zapatillas_count }} productos</span></td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.categorias.edit', $categoria) }}" class="btn btn-ghost" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.categorias.destroy', $categoria) }}" onsubmit="return confirm('¿Estás seguro?')">
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

        <div style="margin-top: 24px;">{{ $categorias->links() }}</div>
    </div>
@endsection
