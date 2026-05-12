@extends('layout.master')

@section('title', 'Dashboard admin | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Resumen general de ventas, pedidos y actividad reciente de la tienda.</p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="metric"><span class="muted">Ventas</span><h3>{{ number_format($stats['ventas'], 2) }} €</h3></div>
            <div class="metric"><span class="muted">Pedidos</span><h3>{{ $stats['pedidos'] }}</h3></div>
            <div class="metric"><span class="muted">Usuarios</span><h3>{{ $stats['usuarios'] }}</h3></div>
            <div class="metric"><span class="muted">Productos</span><h3>{{ $stats['productos'] }}</h3></div>
            <div class="metric"><span class="muted">Categorías</span><h3>{{ $stats['categorias'] }}</h3></div>
            <div class="metric"><span class="muted">Noticias</span><h3>{{ $stats['noticias'] }}</h3></div>
        </div>

        <div class="admin-nav-grid" style="margin-top: 24px;">
            <a href="{{ route('admin.zapatillas.index') }}" class="panel admin-nav-card">
                <i class="fas fa-shoe-prints"></i>
                <span>Zapatillas</span>
            </a>
            <a href="{{ route('admin.categorias.index') }}" class="panel admin-nav-card">
                <i class="fas fa-tags"></i>
                <span>Categorías</span>
            </a>
            <a href="{{ route('admin.pedidos.index') }}" class="panel admin-nav-card">
                <i class="fas fa-shopping-bag"></i>
                <span>Pedidos</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="panel admin-nav-card">
                <i class="fas fa-users"></i>
                <span>Usuarios</span>
            </a>
            <a href="{{ route('admin.descuentos.index') }}" class="panel admin-nav-card">
                <i class="fas fa-percentage"></i>
                <span>Descuentos</span>
            </a>
            <a href="{{ route('admin.noticias.index') }}" class="panel admin-nav-card">
                <i class="fas fa-newspaper"></i>
                <span>Noticias</span>
            </a>
        </div>

        <section class="section">
            <div class="section-head">
                <h2 class="page-title" style="font-size: 1.8rem;">Últimos pedidos</h2>
                <a href="{{ route('admin.pedidos.index') }}" class="btn btn-ghost">Ver todos</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ultimosPedidos as $pedido)
                            <tr>
                                <td><strong>{{ $pedido->numero_pedido }}</strong></td>
                                <td>{{ $pedido->user->name }}</td>
                                <td>
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
                                </td>
                                <td><strong>{{ number_format($pedido->total, 2) }} €</strong></td>
                                <td>
                                    <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-ghost" title="Ver detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
