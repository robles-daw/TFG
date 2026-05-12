@extends('layout.master')

@section('title', 'Admin pedidos | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header"><h1 class="page-title">Pedidos</h1></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->numero_pedido }}</td>
                            <td>{{ $pedido->user->name }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.pedidos.updateEstado', $pedido) }}" class="inline-actions" style="gap: 8px;">
                                    @csrf
                                    @method('PUT')
                                    <div style="position: relative; width: 145px;">
                                        <select name="estado" class="form-select-sm" 
                                            style="
                                                padding: 6px 32px 6px 12px; 
                                                font-size: 0.85rem; 
                                                border-radius: 8px; 
                                                background: var(--bg-soft);
                                                color: var(--text);
                                                appearance: none;
                                                cursor: pointer;
                                                width: 100%;
                                                box-shadow: none;
                                                outline: none;
                                                border: 1.5px solid {{ 
                                                    match($pedido->estado) {
                                                        'entregado' => 'var(--success)',
                                                        'enviado', 'preparando' => 'var(--accent-2)',
                                                        'pendiente', 'confirmado' => '#ffe8a3',
                                                        'cancelado' => 'var(--danger)',
                                                        default => 'var(--line)'
                                                    }
                                                }};
                                                background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%239fb0c4\' stroke-width=\'2.5\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M19 9l-7 7-7-7\'%3E%3C/path%3E%3C/svg%3E');
                                                background-repeat: no-repeat;
                                                background-position: right 10px center;
                                                background-size: 14px;
                                            ">
                                            @foreach(['pendiente','confirmado','preparando','enviado','entregado','cancelado'] as $estado)
                                                <option value="{{ $estado }}" @selected($pedido->estado === $estado)>{{ ucfirst($estado) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-secondary" type="submit" style="padding: 6px 10px; font-size: 0.8rem; border-radius: 8px; background: rgba(46, 196, 182, 0.1); border-color: rgba(46, 196, 182, 0.2);" title="Guardar">
                                        <i class="fas fa-save" style="color: var(--accent-2);"></i>
                                    </button>
                                </form>
                            </td>
                            <td><strong>{{ number_format($pedido->total, 2) }} €</strong></td>
                            <td>
                                <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-ghost" style="padding: 6px 12px; font-size: 0.85rem;">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $pedidos->links() }}
    </div>

    <script>
        document.querySelectorAll('.form-select-sm').forEach(select => {
            select.addEventListener('change', function() {
                const colors = {
                    'entregado': 'var(--success)',
                    'enviado': 'var(--accent-2)',
                    'preparando': 'var(--accent-2)',
                    'pendiente': 'var(--badge-warning)',
                    'confirmado': 'var(--badge-warning)',
                    'cancelado': 'var(--danger)'
                };
                this.style.borderColor = colors[this.value] || 'var(--line)';
            });
        });
    </script>
@endsection
