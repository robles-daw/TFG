@extends('layout.master')

@section('title', 'Perfil | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">{{ $user->name }}</h1>
                <p class="page-subtitle">{{ $user->email }} · {{ ucfirst($user->rol) }}</p>
            </div>
        </div>

        <div class="grid-2" style="gap: 24px; align-items: start;">
            <div>
                <section class="panel" style="padding: 28px; margin-bottom: 24px;">
                    <h2 style="font-size: 1.4rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-truck" style="color: var(--accent);"></i> Datos de Envío
                    </h2>
                    @if($user->direccion)
                        <div style="line-height: 1.8;">
                            <p style="margin: 0; font-weight: 600; font-size: 1.1rem;">{{ $user->name }}</p>
                            <p style="margin: 0;" class="muted">{{ $user->direccion }}</p>
                            <p style="margin: 0;" class="muted">{{ $user->codigo_postal }} {{ $user->ciudad }}</p>
                            <p style="margin: 0;" class="muted">{{ $user->pais }}</p>
                            <p style="margin: 8px 0 0;" class="text-accent"><i class="fas fa-phone"></i> {{ $user->telefono }}</p>
                        </div>
                    @else
                        <p class="muted">No has guardado una dirección de envío todavía.</p>
                    @endif
                    <a href="{{ route('perfil.edit') }}" class="btn btn-ghost" style="margin-top: 20px; width: 100%;">Editar Perfil</a>
                </section>

                <section class="panel" style="padding: 28px;">
                    <h2 style="font-size: 1.4rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-shopping-bag" style="color: var(--accent);"></i> Actividad
                    </h2>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <p style="margin: 0; font-size: 1.2rem; font-weight: 700;">{{ $user->pedidos->count() }}</p>
                            <p style="margin: 0; font-size: 0.9rem;" class="muted">Pedidos totales</p>
                        </div>
                        <a href="{{ route('pedidos.mis_pedidos') }}" class="btn btn-primary">Ver Historial</a>
                    </div>
                </section>
            </div>

            <div>
                <h2 style="font-size: 1.4rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-history" style="color: var(--accent);"></i> Pedidos Recientes
                </h2>
                <div class="form-stack">
                    @forelse($user->pedidos->sortByDesc('created_at')->take(5) as $pedido)
                        <a class="panel" style="padding: 24px; transition: 0.2s ease; display: block;" href="{{ route('pedidos.show', $pedido) }}">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <strong style="font-size: 1.1rem; color: var(--accent);">{{ $pedido->numero_pedido }}</strong>
                                <span class="badge" style="background: rgba(255, 255, 255, 0.05);">
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                <p class="muted" style="font-size: 0.9rem;">{{ optional($pedido->created_at)->format('d M, Y') }}</p>
                                <strong style="font-size: 1.3rem;">{{ number_format($pedido->total, 2) }} €</strong>
                            </div>
                        </a>
                    @empty
                        <div class="panel" style="padding: 40px; text-align: center;">
                            <i class="fas fa-box-open" style="font-size: 2.5rem; color: var(--line); margin-bottom: 12px;"></i>
                            <p class="muted">Aún no has realizado ninguna compra.</p>
                            <a href="{{ route('zapatillas.index') }}" class="text-accent" style="font-weight: 600;">Ir al catálogo</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
