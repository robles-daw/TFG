@extends('layout.master')

@section('title', $zapatilla->nombre . ' | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="detail-layout">
            <div class="product-gallery">
                <div class="panel" style="padding: 12px; margin-bottom: 12px; height: 500px; overflow: hidden;">
                    <img id="main-image" src="{{ $zapatilla->main_image_url }}" alt="{{ $zapatilla->nombre }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                </div>
                <div class="grid-4">
                    <img src="{{ $zapatilla->main_image_url }}" onclick="document.getElementById('main-image').src=this.src" class="panel" style="height: 100px; cursor: pointer; padding: 6px; object-fit: cover;">
                    @foreach($zapatilla->extra_image_urls as $url)
                        <img src="{{ $url }}" onclick="document.getElementById('main-image').src=this.src" class="panel" style="height: 100px; cursor: pointer; padding: 6px; object-fit: cover;">
                    @endforeach
                </div>
            </div>

            <div class="product-info-panel">
                <div class="panel" style="padding: 32px; position: sticky; top: 100px;">
                    <span class="badge" style="background: rgba(255, 107, 53, 0.1); color: var(--accent); margin-bottom: 12px;">
                        {{ $zapatilla->categoria->nombre }}
                    </span>
                    <h1 class="page-title" style="font-size: 3rem; margin-bottom: 8px;">{{ $zapatilla->nombre }}</h1>
                    <p class="muted" style="font-size: 1.2rem; margin-bottom: 8px;">{{ $zapatilla->marca }} · {{ $zapatilla->modelo }}</p>
                    <p style="font-size: 2rem; font-weight: 800; color: var(--text); margin-bottom: 24px;">{{ number_format($zapatilla->precio, 2) }} €</p>

                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="zapatilla_id" value="{{ $zapatilla->id }}">
                        
                        <div style="margin-bottom: 20px;">
                            <label for="talla" style="display: block; margin-bottom: 8px; font-weight: 600;">Selecciona Talla</label>
                            <div class="grid-4" style="gap: 8px;">
                                @foreach($zapatilla->tallasStock as $talla)
                                    @if($talla->stock > 0)
                                        <label class="size-option" style="cursor: pointer;">
                                            <input type="radio" name="talla" value="{{ $talla->talla }}" required style="display: none;">
                                            <div class="size-box" style="border: 2px solid var(--line); border-radius: 8px; padding: 10px; text-align: center; transition: 0.2s;">
                                                {{ (float)$talla->talla }}
                                            </div>
                                        </label>
                                    @else
                                        <div class="size-box disabled" style="border: 2px solid var(--line); border-radius: 8px; padding: 10px; text-align: center; opacity: 0.4; background: rgba(0,0,0,0.1); cursor: not-allowed;">
                                            {{ (float)$talla->talla }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label for="quantity" style="display: block; margin-bottom: 8px; font-weight: 600;">Cantidad</label>
                            <input type="number" name="quantity" value="1" min="1" required style="width: 80px; padding: 10px; background: rgba(255,255,255,0.05); border: 1px solid var(--line); border-radius: 8px; color: white;">
                        </div>

                        @auth
                            <button type="submit" class="btn btn-primary" style="width: 100%; height: 56px; font-weight: 700; font-size: 1.1rem; gap: 12px;">
                                <i class="fas fa-shopping-cart"></i> AÑADIR AL CARRITO
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; height: 56px; font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 12px;">
                                <i class="fas fa-sign-in-alt"></i> INICIA SESIÓN PARA COMPRAR
                            </a>
                        @endauth
                    </form>

                    <style>
                        .size-option input:checked + .size-box {
                            border-color: var(--accent);
                            background: rgba(255, 107, 53, 0.1);
                            color: var(--accent);
                            font-weight: 700;
                        }
                        .size-option:hover .size-box:not(.disabled) {
                            border-color: var(--accent);
                        }
                    </style>


                @if(!empty($zapatilla->imagenes_extra))
                    <div class="section">
                        <h3>Mas imagenes</h3>
                        <div class="grid-2">
                            @foreach($zapatilla->imagenes_extra as $imagen)
                                <div class="product-image" style="height: 180px;">
                                    <img src="{{ $imagen }}" alt="Detalle {{ $zapatilla->nombre }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>

        @if($relacionadas->isNotEmpty())
            <section class="section">
                <div class="page-header">
                    <div>
                        <h2 class="page-title" style="font-size: 2rem;">Relacionadas</h2>
                    </div>
                </div>
                <div class="product-grid">
                    @foreach($relacionadas as $item)
                        <a class="product-card" href="{{ route('zapatillas.show', $item) }}">
                            <div class="product-image">
                                <img src="{{ $item->imagen_principal }}" alt="{{ $item->nombre }}">
                            </div>
                            <h3>{{ $item->nombre }}</h3>
                            <p class="muted">{{ number_format($item->precio, 2) }} €</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
