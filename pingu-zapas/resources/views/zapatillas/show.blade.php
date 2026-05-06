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

                    @php
                        $tallasOrdenadas = $zapatilla->tallasStock->sortBy('talla')->values();
                        $agotadas = $tallasOrdenadas->filter(fn ($talla) => $talla->stock <= 0)->values();
                    @endphp

                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="zapatilla_id" value="{{ $zapatilla->id }}">

                        <div style="margin-bottom: 20px;">
                            <label for="talla" style="display: block; margin-bottom: 8px; font-weight: 600;">Selecciona talla</label>
                            @if($tallasOrdenadas->isNotEmpty())
                                <div class="grid-4" style="gap: 8px;">
                                    @foreach($tallasOrdenadas as $talla)
                                        @php($normalizedTalla = number_format((float) $talla->talla, 1, '.', ''))
                                        <label class="size-option" style="cursor: pointer;">
                                            <input
                                                type="radio"
                                                name="talla"
                                                value="{{ $normalizedTalla }}"
                                                data-stock="{{ (int) $talla->stock }}"
                                                data-is-subscribed="{{ in_array($normalizedTalla, $subscribedSizes, true) ? '1' : '0' }}"
                                                required
                                                style="display: none;"
                                            >
                                            <div class="size-box {{ $talla->stock > 0 ? '' : 'disabled' }}" style="border: 2px solid var(--line); border-radius: 8px; padding: 10px; text-align: center; transition: 0.2s; {{ $talla->stock > 0 ? '' : 'opacity: 0.55; background: rgba(0,0,0,0.1);' }}">
                                                {{ (float) $talla->talla }}
                                                @if($talla->stock <= 0)
                                                    <small style="display: block; margin-top: 4px; font-size: 0.7rem;">Sin stock</small>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="panel" style="padding: 14px; background: rgba(255,255,255,0.03); border: 1px dashed var(--line); color: var(--muted);">
                                    Este producto no tiene tallas configuradas todavia.
                                </div>
                            @endif
                        </div>

                        <div style="margin-bottom: 24px;" id="quantity-wrapper">
                            <label for="quantity" style="display: block; margin-bottom: 8px; font-weight: 600;">Cantidad</label>
                            <input type="number" name="quantity" value="1" min="1" required style="width: 80px; padding: 10px; background: rgba(255,255,255,0.05); border: 1px solid var(--line); border-radius: 8px; color: white;">
                        </div>

                        @if($tallasOrdenadas->isNotEmpty())
                            <button type="submit" class="btn btn-primary" id="add-to-cart-button" style="width: 100%; height: 56px; font-weight: 700; font-size: 1.1rem; gap: 12px; display: none;">
                                <i class="fas fa-shopping-cart"></i> AÑADIR AL CARRITO
                            </button>

                            <a href="{{ route('login') }}" class="btn btn-primary" id="login-to-buy-button" style="width: 100%; height: 56px; font-weight: 700; font-size: 1.1rem; display: none; align-items: center; justify-content: center; gap: 12px;">
                                <i class="fas fa-sign-in-alt"></i> INICIA SESION PARA COMPRAR
                            </a>

                            <button type="button" class="btn btn-secondary" id="stock-alert-button" style="width: 100%; height: 56px; font-weight: 700; font-size: 1.1rem; gap: 12px; display: none;">
                                <i class="fas fa-envelope"></i> AVISAME CUANDO HAYA STOCK
                            </button>

                            <a href="{{ route('login') }}" class="btn btn-secondary" id="stock-alert-guest-button" style="width: 100%; height: 56px; font-weight: 700; font-size: 1.1rem; display: none; align-items: center; justify-content: center; gap: 12px;">
                                <i class="fas fa-sign-in-alt"></i> INICIA SESION PARA RECIBIR AVISO
                            </a>

                        @else
                            @auth
                                <button type="button" class="btn btn-secondary" id="stock-alert-no-sizes-button" style="width: 100%; height: 56px; font-weight: 700; font-size: 1.1rem; gap: 12px;">
                                    <i class="fas fa-envelope"></i> AVISAME CUANDO HAYA STOCK
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-secondary" style="width: 100%; height: 56px; font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 12px;">
                                    <i class="fas fa-sign-in-alt"></i> INICIA SESION PARA RECIBIR AVISO
                                </a>
                            @endauth
                        @endif

                        <div id="stock-alert-feedback" class="muted" style="display: none; margin-top: 10px; font-size: 0.95rem;"></div>
                    </form>

                    @auth
                        <form action="{{ route('stock-alerts.store', $zapatilla) }}" method="POST" id="stock-alert-form" style="display: none;">
                            @csrf
                            <input type="hidden" name="talla" id="stock-alert-talla" value="0">
                        </form>
                    @endauth

                    @if($agotadas->isNotEmpty())
                        <div class="panel" style="margin-top: 18px; padding: 18px; background: rgba(255, 107, 53, 0.08); border: 1px solid rgba(255, 107, 53, 0.22);">
                            <p style="margin: 0 0 12px; font-weight: 700;">Hay tallas agotadas en este producto.</p>
                            <p class="muted" style="margin: 0;">Selecciona una talla agotada arriba y pulsa el boton de aviso. Cuando se reponga, el correo se enviara automaticamente.</p>

                        </div>
                    @elseif($tallasOrdenadas->isEmpty())
                        <div class="panel" style="margin-top: 18px; padding: 18px; background: rgba(255,255,255,0.03); border: 1px solid var(--line);">
                            <p style="margin: 0 0 8px; font-weight: 700;">Todavia no hay stock publicable para este producto.</p>
                            <p class="muted" style="margin: 0;">Anade tallas desde el panel de administracion para que pueda comprarse o activar avisos por talla.</p>
                        </div>
                    @endif

                    <style>
                        .size-option input:checked + .size-box {
                            border-color: var(--accent);
                            background: rgba(255, 107, 53, 0.1);
                            color: var(--accent);
                            font-weight: 700;
                        }

                        .size-option:hover .size-box {
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
                                <img src="{{ $item->main_image_url }}" alt="{{ $item->nombre }}">
                            </div>
                            <h3>{{ $item->nombre }}</h3>
                            <p class="muted">{{ number_format($item->precio, 2) }} €</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tallaInputs = document.querySelectorAll('input[name="talla"]');
        const addToCartButton = document.getElementById('add-to-cart-button');
        const loginToBuyButton = document.getElementById('login-to-buy-button');
        const stockAlertButton = document.getElementById('stock-alert-button');
        const stockAlertGuestButton = document.getElementById('stock-alert-guest-button');
        const stockAlertNoSizesButton = document.getElementById('stock-alert-no-sizes-button');
        const stockAlertForm = document.getElementById('stock-alert-form');
        const stockAlertTallaInput = document.getElementById('stock-alert-talla');
        const stockAlertFeedback = document.getElementById('stock-alert-feedback');
        const quantityWrapper = document.getElementById('quantity-wrapper');
        const isAuth = {{ Auth::check() ? 'true' : 'false' }};

        const updateActions = () => {
            const selected = document.querySelector('input[name="talla"]:checked');

            // Reset talla-specific elements
            if (addToCartButton) addToCartButton.style.display = 'none';
            if (loginToBuyButton) loginToBuyButton.style.display = 'none';
            if (stockAlertButton) stockAlertButton.style.display = 'none';
            if (stockAlertGuestButton) stockAlertGuestButton.style.display = 'none';
            if (stockAlertFeedback) stockAlertFeedback.style.display = 'none';

            if (!selected) {
                if (quantityWrapper) quantityWrapper.style.display = 'block';
                return;
            }

            const hasStock = Number(selected.dataset.stock) > 0;
            const alreadySubscribed = selected.dataset.isSubscribed === '1';

            if (hasStock) {
                if (isAuth) {
                    if (addToCartButton) addToCartButton.style.display = 'inline-flex';
                } else {
                    if (loginToBuyButton) loginToBuyButton.style.display = 'inline-flex';
                }
                if (quantityWrapper) quantityWrapper.style.display = 'block';
            } else {
                if (isAuth) {
                    if (stockAlertButton) stockAlertButton.style.display = 'inline-flex';
                } else {
                    if (stockAlertGuestButton) stockAlertGuestButton.style.display = 'inline-flex';
                }
                if (quantityWrapper) quantityWrapper.style.display = 'none';
                if (stockAlertFeedback) {
                    stockAlertFeedback.style.display = 'block';
                    stockAlertFeedback.textContent = alreadySubscribed
                        ? 'Ya tienes activado el aviso para esta talla.'
                        : 'Recibirás un correo automáticamente cuando vuelva a haber stock.';
                    stockAlertFeedback.style.color = 'var(--muted)';
                    stockAlertFeedback.style.background = 'transparent';
                    stockAlertFeedback.style.border = 'none';
                    stockAlertFeedback.style.padding = '0';
                    stockAlertFeedback.style.marginTop = '10px';
                }
            }
        };

        const submitStockAlert = async (tallaValue) => {
            if (!stockAlertForm) return;

            const btn = stockAlertButton && stockAlertButton.style.display !== 'none' 
                ? stockAlertButton 
                : stockAlertNoSizesButton;

            if (btn) {
                btn.disabled = true;
                btn.dataset.oldHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ENVIANDO...';
            }

            if (stockAlertTallaInput) stockAlertTallaInput.value = tallaValue;

            try {
                const response = await fetch(stockAlertForm.action, {
                    method: 'POST',
                    body: new FormData(stockAlertForm),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (!response.ok) throw new Error(data.message || 'Error en el servidor');

                if (stockAlertFeedback) {
                    stockAlertFeedback.style.display = 'block';
                    stockAlertFeedback.textContent = data.message;
                    stockAlertFeedback.style.color = data.status === 'success' ? '#10b981' : '#f97316';
                    stockAlertFeedback.style.fontWeight = '700';
                    stockAlertFeedback.style.padding = '12px';
                    stockAlertFeedback.style.background = 'rgba(16, 185, 129, 0.1)';
                    stockAlertFeedback.style.border = '1px solid ' + (data.status === 'success' ? '#10b98133' : '#f9731633');
                    stockAlertFeedback.style.borderRadius = '12px';
                    stockAlertFeedback.style.marginTop = '16px';
                }

                if (btn) btn.style.display = 'none';

            } catch (error) {
                alert('Error: ' + error.message);
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = btn.dataset.oldHtml || '<i class="fas fa-envelope"></i> AVISAME CUANDO HAYA STOCK';
                }
            }
        };

        tallaInputs.forEach(input => input.addEventListener('change', updateActions));

        if (stockAlertButton) {
            stockAlertButton.addEventListener('click', (e) => {
                e.preventDefault();
                const selected = document.querySelector('input[name="talla"]:checked');
                submitStockAlert(selected ? selected.value : "0");
            });
        }

        if (stockAlertNoSizesButton) {
            stockAlertNoSizesButton.addEventListener('click', (e) => {
                e.preventDefault();
                submitStockAlert("0");
            });
        }

        updateActions();
    });
</script>
@endsection
