@extends('layout.master')

@section('title', 'Finalizar Pedido | Pingu Zapas')

@section('content')
    <div class="container">
        <h1 class="page-title">Finalizar Pedido</h1>
        
        <form action="{{ route('checkout.process') }}" method="POST" class="catalog-layout" style="grid-template-columns: 1fr 380px;">
            @csrf
            
            <div class="form-stack">
                <section class="panel" style="padding: 24px;">
                    <h3 style="margin-top: 0; margin-bottom: 20px;">Datos de Envío</h3>
                    <div class="grid-2">
                        <div class="field">
                            <label for="nombre_envio">Nombre completo</label>
                            <input id="nombre_envio" type="text" name="nombre_envio" value="{{ old('nombre_envio', $user->name) }}" required>
                        </div>
                        <div class="field">
                            <label for="telefono_contacto">Teléfono</label>
                            <input id="telefono_contacto" type="text" name="telefono_contacto" value="{{ old('telefono_contacto', $user->telefono) }}" required>
                        </div>
                    </div>
                    <div class="field" style="margin-top: 14px;">
                        <label for="direccion_envio">Dirección</label>
                        <input id="direccion_envio" type="text" name="direccion_envio" value="{{ old('direccion_envio', $user->direccion) }}" required>
                    </div>
                    <div class="grid-3" style="margin-top: 14px;">
                        <div class="field">
                            <label for="ciudad_envio">Ciudad</label>
                            <input id="ciudad_envio" type="text" name="ciudad_envio" value="{{ old('ciudad_envio', $user->ciudad) }}" required>
                        </div>
                        <div class="field">
                            <label for="codigo_postal_envio">C.P.</label>
                            <input id="codigo_postal_envio" type="text" name="codigo_postal_envio" value="{{ old('codigo_postal_envio', $user->codigo_postal) }}" required>
                        </div>
                        <div class="field">
                            <label for="pais_envio">País</label>
                            <input id="pais_envio" type="text" name="pais_envio" value="{{ old('pais_envio', $user->pais ?: 'España') }}" required>
                        </div>
                    </div>
                </section>

                <section class="panel" style="padding: 24px; margin-top: 18px;">
                    <h3 style="margin-top: 0; margin-bottom: 20px;">Método de Pago</h3>
                    <div class="grid-2">
                        <label class="panel badge" style="padding: 16px; display: flex; gap: 12px; cursor: pointer; background: var(--bg-soft); border-color: var(--line);">
                            <input type="radio" name="metodo_pago" value="tarjeta" checked>
                            <span>Tarjeta Bancaria</span>
                        </label>
                        <label class="panel badge" style="padding: 16px; display: flex; gap: 12px; cursor: pointer; background: var(--bg-soft); border-color: var(--line);">
                            <input type="radio" name="metodo_pago" value="paypal">
                            <span>PayPal</span>
                        </label>
                    </div>
                </section>
            </div>

            <aside>
                <div class="panel" style="padding: 24px;">
                    <h3 style="margin-top: 0;">Resumen del Pedido</h3>
                    <div class="list-clean">
                        @foreach($items as $item)
                            <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <div style="position: relative;">
                                        <img src="{{ $item['zapatilla']->imagen_principal }}" style="width: 44px; height: 44px; border-radius: 6px; object-fit: cover;">
                                        <span class="badge" style="position: absolute; top: -8px; right: -8px; padding: 2px 6px; font-size: 0.75rem; background: var(--accent);">
                                            {{ $item['quantity'] }}
                                        </span>
                                    </div>
                                    <div style="font-size: 0.9rem;">
                                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 160px;">{{ $item['zapatilla']->nombre }}</div>
                                        <small class="muted">Talla {{ $item['talla'] }}</small>
                                    </div>
                                </div>
                                <span style="font-weight: 500;">{{ number_format($item['subtotal'], 2) }} €</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <hr style="border: none; border-top: 1px solid var(--line); margin: 16px 0;">
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.9rem;">
                        <span class="muted">Subtotal</span>
                        <span>{{ number_format($total, 2) }} €</span>
                    </div>

                    @if($discount > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.9rem; color: var(--success);">
                            <span class="muted" style="color: var(--success);">Descuento</span>
                            <span>-{{ number_format($discount, 2) }} €</span>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.9rem;">
                        <span class="muted">Gastos de envío</span>
                        <span>{{ $total > 150 ? 'Gratis' : '9.99 €' }}</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 1.4rem;">
                        <span>Total</span>
                        <strong class="text-accent">{{ number_format(($total - $discount) + ($total > 150 ? 0 : 9.99), 2) }} €</strong>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; font-weight: 700;">CONFIRMAR Y PAGAR</button>
                    
                    <p class="muted" style="font-size: 0.8rem; margin-top: 16px; text-align: center;">
                        <i class="fas fa-lock" style="margin-right: 4px;"></i> Pago seguro 100% encriptado
                    </p>
                </div>
            </aside>
        </form>
    </div>
@endsection
