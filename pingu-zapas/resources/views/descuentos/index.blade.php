@extends('layout.master')

@section('title', 'Descuentos | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Descuentos</h1>
            <a href="{{ route('admin.descuentos.create') }}" class="btn btn-primary">Nuevo descuento</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Activo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($descuentos as $descuento)
                        <tr>
                            <td><strong style="font-family: monospace; letter-spacing: 1px;">{{ $descuento->codigo }}</strong></td>
                            <td>
                                <span class="badge" style="background: {{ $descuento->tipo === 'porcentaje' ? 'rgba(46, 196, 182, 0.1)' : 'rgba(255, 107, 53, 0.1)' }}; color: {{ $descuento->tipo === 'porcentaje' ? 'var(--accent-2)' : 'var(--accent)' }};">
                                    {{ ucfirst($descuento->tipo) }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ $descuento->tipo === 'porcentaje' ? $descuento->valor . '%' : number_format($descuento->valor, 2) . ' €' }}</strong>
                            </td>
                            <td>
                                <span class="badge {{ $descuento->activo ? 'badge-success' : 'badge-warning' }}">
                                    {{ $descuento->activo ? 'Activo' : 'Pausado' }}
                                </span>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.descuentos.edit', $descuento) }}" class="btn btn-ghost" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.descuentos.destroy', $descuento) }}" onsubmit="return confirm('¿Seguro que quieres eliminar este descuento?')">
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
        {{ $descuentos->links() }}
    </div>
@endsection
