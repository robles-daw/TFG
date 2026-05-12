@extends('layout.master')

@section('title', 'Mis pedidos | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header"><h1 class="page-title">Mis pedidos</h1></div>
        <div class="cards-grid">
            @foreach($pedidos as $pedido)
                <a class="panel" style="padding: 20px;" href="{{ route('pedidos.show', $pedido) }}">
                    <div class="inline-actions" style="justify-content: space-between;">
                        <strong>{{ $pedido->numero_pedido }}</strong>
                        <span class="badge">{{ ucfirst($pedido->estado) }}</span>
                    </div>
                    <p class="muted">{{ $pedido->items->count() }} lineas · {{ optional($pedido->created_at)->format('d/m/Y') }}</p>
                    <strong>{{ number_format($pedido->total, 2) }} €</strong>
                </a>
            @endforeach
        </div>
        <div style="margin-top: 24px;">{{ $pedidos->links() }}</div>
    </div>
@endsection
