@extends('layout.master')

@section('title', 'Editar zapatilla | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Editar zapatilla</h1>
            <a href="{{ route('admin.zapatillas.index') }}" class="btn btn-ghost">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>
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
            
            <form id="form-talla" method="POST" action="{{ route('admin.tallas.store', $zapatilla) }}" class="grid-3" style="margin-bottom: 24px; align-items: end;">
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
                    <tbody id="tallas-tbody">
                        @forelse($zapatilla->tallasStock->sortBy('talla') as $talla)
                            <tr id="talla-row-{{ $talla->id }}">
                                <td><strong style="font-size: 1.1rem;">{{ $talla->talla }}</strong></td>
                                <td>
                                    <span class="badge {{ $talla->stock > 5 ? 'badge-success' : ($talla->stock > 0 ? 'badge-warning' : 'badge-danger') }}">
                                        {{ $talla->stock }} unidades
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <form method="POST" action="{{ route('admin.tallas.destroy', $talla) }}" class="form-delete-talla" data-id="{{ $talla->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost btn-delete-talla" style="color: var(--danger); padding: 6px 12px;">
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
            
            <div style="margin-top: 24px; text-align: center;">
                <a href="{{ route('admin.zapatillas.index') }}" class="btn btn-primary" style="padding: 12px 32px;">
                    <i class="fas fa-check-circle"></i> Finalizar y volver al listado
                </a>
            </div>
        </section>
    </div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formTalla = document.getElementById('form-talla');
    const tbody = document.getElementById('tallas-tbody');

    if (formTalla) {
        formTalla.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    // Si la talla ya existe, actualizamos la fila. Si no, la creamos.
                    let row = document.getElementById(`talla-row-${result.id}`);
                    const badgeClass = result.stock > 5 ? 'badge-success' : (result.stock > 0 ? 'badge-warning' : 'badge-danger');
                    
                    const rowHtml = `
                        <td><strong style="font-size: 1.1rem;">${result.talla}</strong></td>
                        <td>
                            <span class="badge ${badgeClass}">
                                ${result.stock} unidades
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <form method="POST" action="${result.destroy_url}" class="form-delete-talla" data-id="${result.id}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-delete-talla" style="color: var(--danger); padding: 6px 12px;">
                                    <i class="fas fa-times"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    `;

                    if (row) {
                        row.innerHTML = rowHtml;
                    } else {
                        // Eliminar el mensaje de "No hay tallas" si existe
                        const emptyRow = tbody.querySelector('td.muted');
                        if (emptyRow) emptyRow.closest('tr').remove();

                        row = document.createElement('tr');
                        row.id = `talla-row-${result.id}`;
                        row.innerHTML = rowHtml;
                        
                        // Insertar ordenado por talla (simple)
                        tbody.appendChild(row);
                        
                        // Re-ordenar filas
                        Array.from(tbody.querySelectorAll('tr'))
                            .sort((a, b) => parseFloat(a.cells[0].innerText) - parseFloat(b.cells[0].innerText))
                            .forEach(tr => tbody.appendChild(tr));
                    }

                    this.reset();
                    document.getElementById('talla').focus();
                } else {
                    alert('Error: ' + (result.message || 'No se pudo guardar la talla'));
                }
            } catch (error) {
                console.error(error);
                alert('Error de conexión al guardar la talla');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });
    }

    // Delegación de eventos para eliminar
    tbody.addEventListener('submit', async function(e) {
        if (e.target.classList.contains('form-delete-talla')) {
            e.preventDefault();
            
            if (!confirm('¿Eliminar esta talla?')) return;

            const form = e.target;
            const btn = form.querySelector('button');
            const rowId = form.dataset.id;
            const row = document.getElementById(`talla-row-${rowId}`);

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        if (tbody.querySelectorAll('tr').length === 0) {
                            tbody.innerHTML = '<tr><td colspan="3" class="muted" style="text-align: center; padding: 32px;">No hay tallas registradas para este producto.</td></tr>';
                        }
                    }, 300);
                }
            } catch (error) {
                console.error(error);
                alert('Error al eliminar la talla');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-times"></i> Eliminar';
            }
        }
    });
});
</script>
@endpush
@endsection
