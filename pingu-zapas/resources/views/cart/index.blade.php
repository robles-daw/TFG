@extends('layout.master')

@section('title', 'Mi Carrito | Pingu Zapas')

@section('content')
    <div class="container">
        <h1 class="page-title">Tu Carrito</h1>
        
        @if(count($items) > 0)
            <div class="catalog-layout" style="grid-template-columns: 1fr 340px;">
                <div class="panel" style="padding: 0; overflow: hidden;">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Talla</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $cartId => $item)
                                    <tr>
                                        <td>
                                            <div style="display: flex; gap: 12px; align-items: center;">
                                                <img src="{{ $item['zapatilla']->main_image_url }}" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                                                <div>
                                                    <strong>{{ $item['zapatilla']->nombre }}</strong><br>
                                                    <small class="muted">{{ $item['zapatilla']->marca }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item['talla'] }}</td>
                                        <td>{{ number_format($item['zapatilla']->precio, 2) }} €</td>
                                        <td>
                                            <form action="{{ route('cart.update') }}" method="POST" style="display: flex; gap: 6px; align-items: center;">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $cartId }}">
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width: 60px; padding: 4px 8px; border-radius: 6px; border: 1px solid var(--line); background: var(--bg-soft); color: var(--text);">
                                                <button type="submit" class="btn btn-ghost" style="padding: 4px 8px; font-size: 0.8rem;">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td><strong>{{ number_format($item['subtotal'], 2) }} €</strong></td>
                                        <td>
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $cartId }}">
                                                <button type="submit" class="btn badge badge-danger" style="background: none; border: none; cursor: pointer; color: var(--danger);">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <aside>
                    <div class="panel" style="padding: 24px;">
                        <h3>Resumen</h3>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <span class="muted">Subtotal</span>
                            <strong>{{ number_format($total, 2) }} €</strong>
                        </div>

                        @if($appliedCoupon)
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: var(--success);">
                                <span>Descuento ({{ $appliedCoupon->codigo }})</span>
                                <strong>-{{ number_format($discount, 2) }} €</strong>
                            </div>
                        @endif

                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <span class="muted">Envío</span>
                            <span>{{ $total > 150 ? 'Gratis' : '9.99 €' }}</span>
                        </div>

                        @if($appliedCoupon)
                            <form action="{{ route('cart.coupon.remove') }}" method="POST" style="margin: 16px 0;">
                                @csrf
                                <button type="submit" class="btn btn-ghost" style="width: 100%; padding: 6px; font-size: 0.75rem; border-color: var(--danger); color: var(--danger);">
                                    <i class="fas fa-times"></i> Quitar cupón [{{ $appliedCoupon->codigo }}]
                                </button>
                            </form>
                        @else
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" style="margin: 16px 0;">
                                @csrf
                                <div style="display: flex; gap: 8px;">
                                    <input type="text" name="codigo" placeholder="Código de descuento" style="flex: 1; padding: 8px 12px; border-radius: 10px; border: 1px solid var(--line); background: var(--bg-soft); color: var(--text); font-size: 0.9rem;" required>
                                    <button type="submit" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.9rem;">Aplicar</button>
                                </div>
                            </form>
                        @endif

                        <hr style="border: none; border-top: 1px solid var(--line); margin: 16px 0;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 1.4rem;">
                            <span>Total</span>
                            <strong class="text-accent">{{ number_format(($total - $discount) + ($total > 150 ? 0 : 9.99), 2) }} €</strong>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="width: 100%;">Tramitar Pedido</a>
                        <p class="muted" style="font-size: 0.8rem; margin-top: 12px; text-align: center;">
                            Envío gratuito para pedidos superiores a 150€
                        </p>
                    </div>
                </aside>
            </div>
        @else
            <div class="panel" style="padding: 60px; text-align: center;">
                <i class="fas fa-shopping-cart" style="font-size: 4rem; color: var(--line); margin-bottom: 20px;"></i>
                <h2>Tu carrito está vacío</h2>
                <p class="muted">¿Aún no has encontrado tus zapas ideales?</p>
                <a href="{{ route('zapatillas.index') }}" class="btn btn-primary" style="margin-top: 24px;">Ver catálogo</a>
            </div>
        @endif
    </div>
@endsection
