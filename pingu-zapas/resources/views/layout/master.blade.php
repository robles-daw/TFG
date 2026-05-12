<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pingu Zapas')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/modern.css') }}?v=2">
    <link rel="icon" href="{{ asset('img/logoZapas.png') }}?v=2" type="image/png">
    @stack('styles')
    <style>
        .cookies {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: min(420px, calc(100% - 40px));
            padding: 18px;
            color: var(--text);
            background:
                linear-gradient(135deg, rgba(255, 107, 53, 0.16), transparent 42%),
                rgba(12, 22, 32, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 22px;
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(18px);
            z-index: 9999;
            opacity: 0;
            transform: translateY(32px) scale(0.98);
            pointer-events: none;
            transition: opacity 0.35s ease, transform 0.35s ease;
        }

        .cookies.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .cookies.oculto {
            opacity: 0;
            transform: translateY(40px) scale(0.98);
        }

        .cookies h2 {
            margin: 0 0 8px;
            font-size: 1.05rem;
            font-weight: 800;
        }

        .cookies p,
        .cookies-info {
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .cookies p {
            margin: 0;
        }

        .cookies-info {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-8px);
            transition: max-height 0.35s ease, opacity 0.25s ease, transform 0.35s ease;
        }

        .cookies-info.visible {
            max-height: 260px;
            opacity: 1;
            transform: translateY(0);
        }

        .cookies-info ul {
            margin: 12px 0 0;
            padding-left: 20px;
        }

        .cookies-botones {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 14px;
        }

        .cookies button {
            flex: 1 1 112px;
            padding: 10px 12px;
            border-radius: 999px;
            border: 1px solid transparent;
            cursor: pointer;
            color: var(--text);
            transition: transform 0.2s ease, border-color 0.2s ease, background 0.2s ease;
        }

        .btn-aceptar-cookies {
            background: var(--accent);
        }

        .btn-cookies {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--line);
        }

        .cookies button:hover {
            transform: translateY(-1px);
        }

        @media (max-width: 480px) {
            .cookies {
                right: 12px;
                bottom: 12px;
                width: calc(100% - 24px);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container nav-shell">
            <a href="{{ route('index') }}" class="nav-brand">
                <img src="{{ asset('img/logoZapas.png') }}" alt="Pingu Zapas">
                Pingu<span>Zapas</span>
            </a>

            <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
                <i class="fas fa-bars"></i>
            </button>

            <div class="nav-links">
                <a href="{{ route('index') }}">Inicio</a>
                <a href="{{ route('zapatillas.index') }}">Catálogo</a>
                <a href="{{ route('categorias.index') }}">Categorías</a>
                <a href="{{ route('noticias.index') }}">Noticias</a>
                <a href="{{ route('contacto.index') }}">Contacto</a>
                @auth
                    @if(auth()->user()->rol === 'admin')
                        <div style="width: 1px; height: 20px; background: var(--line); margin: 0 8px;"></div>
                        <a href="{{ route('admin.dashboard') }}" style="color: var(--accent);">Dashboard</a>
                    @else
                        <a href="{{ route('perfil.index') }}">Perfil</a>
                    @endif
                @endauth
            </div>

            <div class="nav-icons">
                <a href="{{ route('cart.index') }}" class="nav-cart" style="position: relative;">
                    <i class="fas fa-shopping-cart"></i>
                    @if(count(session('cart', [])) > 0)
                        <span class="badge" style="position: absolute; top: -10px; right: -12px; padding: 2px 6px; font-size: 0.7rem; background: var(--accent); color: white;">
                            {{ count(session('cart', [])) }}
                        </span>
                    @endif
                </a>
                @auth
                    <span class="nav-user">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link-button">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Entrar</a>
                    <a href="{{ route('register') }}">Registro</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="page-main">
        <div class="container flash-stack">
            @if(session('success'))
                <div class="flash flash-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="flash flash-error">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="flash flash-error">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div class="footer-info">
                <div class="footer-brand">
                    <img src="{{ asset('img/logoZapas.png') }}" alt="Pingu Zapas">
                    Pingu<span>Zapas</span>
                </div>
                <p>Tu tienda de confianza para descubrir sneakers seleccionadas, lanzamientos especiales y modelos pensados para el día a día.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div>
                <h4>Explorar</h4>
                <a href="{{ route('index') }}">Inicio</a>
                <a href="{{ route('zapatillas.index') }}">Catálogo</a>
                <a href="{{ route('categorias.index') }}">Categorías</a>
                <a href="{{ route('noticias.index') }}">Noticias y guías</a>
            </div>
            <div>
                <h4>Mi Cuenta</h4>
                @auth
                    <a href="{{ route('perfil.index') }}">Mi perfil</a>
                    <a href="{{ route('pedidos.mis_pedidos') }}">Mis Pedidos</a>
                    <a href="#">Lista de Deseos</a>
                @else
                    <a href="{{ route('login') }}">Iniciar sesión</a>
                    <a href="{{ route('register') }}">Crear una cuenta</a>
                @endauth
            </div>
        </div>
        <div class="container footer-bottom">
            <div>&copy; {{ date('Y') }} Pingu Zapas S.L. Todos los derechos reservados.</div>
            <div style="display: flex; gap: 24px;">
                <a href="#" class="muted">Privacidad</a>
                <a href="#" class="muted">Términos</a>
                <a href="#" class="muted">Cookies</a>
            </div>
        </div>
    </footer>
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-header">
            <div class="nav-brand">
                <img src="{{ asset('img/logoZapas.png') }}" alt="Pingu Zapas">
                Pingu<span>Zapas</span>
            </div>
            <button class="menu-close" id="menuClose"><i class="fas fa-times"></i></button>
        </div>
        <div class="mobile-menu-links">
            <a href="{{ route('index') }}">Inicio</a>
            <a href="{{ route('zapatillas.index') }}">Catálogo</a>
            <a href="{{ route('categorias.index') }}">Categorías</a>
            <a href="{{ route('noticias.index') }}">Noticias</a>
            <hr style="border: 0; border-top: 1px solid var(--line); margin: 8px 0;">
            @auth
                @if(auth()->user()->rol === 'admin')
                    <a href="{{ route('admin.dashboard') }}" style="color: var(--accent);">Panel Admin</a>
                    <a href="{{ route('admin.zapatillas.index') }}">Gestionar productos</a>
                    <a href="{{ route('admin.categorias.index') }}">Gestionar categorías</a>
                    <a href="{{ route('admin.pedidos.index') }}">Gestionar pedidos</a>
                @else
                    <a href="{{ route('perfil.index') }}">Mi Perfil</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="margin-top: 8px;">
                    @csrf
                    <button type="submit" class="btn btn-ghost" style="width: 100%;">Cerrar Sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="margin-top: 8px;">Crear cuenta</a>
            @endauth
        </div>
    </div>

    <section id="cookies" class="cookies" aria-live="polite">
        <h2>Cookies en Pingu Zapas</h2>
        <p>
            Usamos cookies necesarias para mantener tu sesión y, si aceptas, recordar tu perfil en este navegador.
        </p>

        <div id="infoCookies" class="cookies-info">
            <p>
                Las cookies de sesión nos ayudan a conservar tu carrito, proteger tu acceso y mejorar la experiencia de navegación. Las cookies opcionales permiten recordar tu perfil durante más tiempo.
            </p>
            <ul>
                <li>No vendemos tus datos personales.</li>
                <li>Puedes rechazar cookies opcionales y seguir navegando.</li>
                <li>Si cierras sesión manualmente, el recuerdo de acceso se elimina.</li>
            </ul>
        </div>

        <div class="cookies-botones">
            <button type="button" id="btnInfoCookies" class="btn-cookies" aria-expanded="false" aria-controls="infoCookies">Más información</button>
            <button type="button" id="btnRechazarCookies" class="btn-cookies">Rechazar</button>
            <button type="button" id="btnAceptarCookies" class="btn-aceptar-cookies">Aceptar</button>
        </div>
    </section>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const menuClose = document.getElementById('menuClose');
        const mobileMenu = document.getElementById('mobileMenu');

        menuToggle.addEventListener('click', () => mobileMenu.classList.add('active'));
        menuClose.addEventListener('click', () => mobileMenu.classList.remove('active'));

        // Cerrar al hacer click fuera
        document.addEventListener('click', (e) => {
            if (mobileMenu.classList.contains('active') && !mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                mobileMenu.classList.remove('active');
            }
        });

        const cookies = document.getElementById('cookies');
        const infoCookies = document.getElementById('infoCookies');
        const btnInfo = document.getElementById('btnInfoCookies');
        const btnAceptar = document.getElementById('btnAceptarCookies');
        const btnRechazar = document.getElementById('btnRechazarCookies');
        const recordarme = document.querySelector('input[name="remember"]');

        function guardarCookie(nombre, valor, dias) {
            const fecha = new Date();
            fecha.setTime(fecha.getTime() + dias * 24 * 60 * 60 * 1000);
            document.cookie = `${nombre}=${valor}; expires=${fecha.toUTCString()}; path=/; SameSite=Lax`;
        }

        function existeCookie(nombre) {
            return document.cookie.includes(`${nombre}=`);
        }

        function cerrarCookies() {
            cookies.classList.add('oculto');
            setTimeout(() => cookies.style.display = 'none', 400);
        }

        if (!existeCookie('cookieConsent')) {
            cookies.classList.add('visible');
        }

        btnAceptar.addEventListener('click', () => {
            guardarCookie('cookieConsent', 'accepted', 365);
            if (recordarme) recordarme.checked = true;
            cerrarCookies();
        });

        btnRechazar.addEventListener('click', () => {
            guardarCookie('cookieConsent', 'rejected', 365);
            if (recordarme) recordarme.checked = false;
            cerrarCookies();
        });

        btnInfo.addEventListener('click', () => {
            infoCookies.classList.toggle('visible');
            const abierto = infoCookies.classList.contains('visible');
            btnInfo.textContent = abierto ? 'Ocultar información' : 'Más información';
            btnInfo.setAttribute('aria-expanded', abierto);
        });
    </script>
    @stack('scripts')
</body>
</html>
