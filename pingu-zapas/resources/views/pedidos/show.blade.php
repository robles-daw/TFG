@extends('layout.master')

@section('title', $pedido->numero_pedido . ' | Pingu Zapas')

@section('content')
    <div class="container">
        <section class="panel" style="padding: 24px;">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Pedido {{ $pedido->numero_pedido }}</h1>
                    <p class="page-subtitle">
                        {{ $pedido->user->name }} · 
                        <span class="badge" style="color: {{
                            match($pedido->estado) {
                                'entregado' => 'var(--success)',
                                'enviado', 'preparando' => 'var(--accent-2)',
                                'pendiente', 'confirmado' => '#ffe8a3',
                                'cancelado' => 'var(--danger)',
                                default => 'var(--muted)'
                            }
                        }}; background: {{
                            match($pedido->estado) {
                                'entregado' => 'rgba(96, 211, 148, 0.1)',
                                'enviado', 'preparando' => 'rgba(46, 196, 182, 0.1)',
                                'pendiente', 'confirmado' => 'rgba(255, 214, 102, 0.1)',
                                'cancelado' => 'rgba(255, 107, 107, 0.1)',
                                default => 'rgba(255, 255, 255, 0.05)'
                            }
                        }};">
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="table-wrap" style="padding: 0;">
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Talla</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido->items as $item)
                            <tr>
                                <td>
                                    <div style="display: flex; gap: 12px; align-items: center;">
                                        <img src="{{ $item->zapatilla->main_image_url }}" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                                        <span>{{ $item->zapatilla->nombre }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->talla }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ number_format($item->subtotal, 2) }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="grid-2 section">
                <div>
                    <h3>Envio</h3>
                    <p class="muted">{{ $pedido->nombre_envio }}</p>
                    <p class="muted">{{ $pedido->direccion_envio }}</p>
                    <p class="muted">{{ $pedido->codigo_postal_envio }} {{ $pedido->ciudad_envio }} · {{ $pedido->pais_envio }}</p>
                </div>
                <div>
                    <h3>Resumen</h3>
                    <p class="muted">Subtotal: {{ number_format($pedido->subtotal, 2) }} €</p>
                    <p class="muted">Descuento: {{ number_format($pedido->descuento_aplicado, 2) }} €</p>
                    <p class="muted">Envio: {{ number_format($pedido->gastos_envio, 2) }} €</p>
                    <strong>Total: {{ number_format($pedido->total, 2) }} €</strong>
                </div>
            </div>
        </section>
    </div>
@endsection
