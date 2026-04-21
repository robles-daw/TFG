@extends('layout.master')

@section('title', 'Editar zapatilla | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header"><h1 class="page-title">Editar zapatilla</h1></div>
        <section class="panel" style="padding: 24px; margin-bottom: 18px;">
            <form method="POST" action="{{ route('admin.zapatillas.update', $zapatilla) }}" class="form-stack" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('zapatillas.partials.form', ['zapatilla' => $zapatilla])
            </form>
        </section>

        <section class="panel" style="padding: 24px;">
            <div class="section-head">
                <h2 class="page-title" style="font-size: 1.8rem;"><i class="fas fa-boxes"></i> Gestión de Stock por Talla</h2>
            </div>
            
            <form method="POST" action="{{ route('admin.tallas.store', $zapatilla) }}" class="grid-3" style="margin-bottom: 24px; align-items: end;">
                @csrf
                <div class="field">
                    <label for="talla">Nueva Talla</label>
                    <input id="talla" type="number" step="0.5" name="talla" placeholder="Ej: 42.5" required>
                </div>
                <div class="field">
                    <label for="stock">Stock Inicial</label>
                    <input id="stock" type="number" name="stock" min="0" placeholder="0" required>
                </div>
                <button class="btn btn-primary" type="submit" style="height: 48px;">Añadir Talla</button>
            </form>

            <div class="table-wrap" style="padding: 0; background: var(--bg-soft);">
                <table>
                    <thead>
                        <tr>
                            <th>Talla</th>
                            <th>Stock Disponible</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($zapatilla->tallasStock->sortBy('talla') as $talla)
                            <tr>
                                <td><strong style="font-size: 1.1rem;">{{ $talla->talla }}</strong></td>
                                <td>
                                    <span class="badge {{ $talla->stock > 5 ? 'badge-success' : ($talla->stock > 0 ? 'badge-warning' : 'badge-danger') }}">
                                        {{ $talla->stock }} unidades
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <form method="POST" action="{{ route('admin.tallas.destroy', $talla) }}" onsubmit="return confirm('¿Eliminar esta talla?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost" style="color: var(--danger); padding: 6px 12px;">
                                            <i class="fas fa-times"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="muted" style="text-align: center; padding: 32px;">No hay tallas registradas para este producto.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
