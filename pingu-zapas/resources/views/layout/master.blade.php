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
    <link rel="stylesheet" href="{{ asset('css/modern.css') }}">
    @stack('styles')
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
                <a href="{{ route('zapatillas.index') }}">Catalogo</a>
                <a href="{{ route('categorias.index') }}">Categorias</a>
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
                <p>Tu destino premium para sneakers de edición limitada y lanzamientos exclusivos. Elevamos tu estilo, paso a paso.</p>
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
                <a href="{{ route('noticias.index') }}">Blog de Noticias</a>
            </div>
            <div>
                <h4>Mi Cuenta</h4>
                @auth
                    <a href="{{ route('perfil.index') }}">Panel de Usuario</a>
                    <a href="{{ route('pedidos.mis_pedidos') }}">Mis Pedidos</a>
                    <a href="#">Lista de Deseos</a>
                @else
                    <a href="{{ route('login') }}">Iniciar Sesión</a>
                    <a href="{{ route('register') }}">Crear una Cuenta</a>
                @endauth
            </div>
            <div>
                <h4>Newsletter</h4>
                <p>Suscríbete para recibir acceso prioritario a nuevos lanzamientos.</p>
                <form onsubmit="return false;" style="margin-top: 12px; display: flex; gap: 8px;">
                    <input type="email" placeholder="tu@email.com" style="flex: 1; padding: 10px 14px; border-radius: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--line); color: white;">
                    <button class="btn btn-primary" style="padding: 10px;"><i class="fas fa-paper-plane"></i></button>
                </form>
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
                    <a href="{{ route('admin.zapatillas.index') }}">Gestionar Productos</a>
                    <a href="{{ route('admin.categorias.index') }}">Gestionar Categorías</a>
                    <a href="{{ route('admin.pedidos.index') }}">Gestionar Pedidos</a>
                @else
                    <a href="{{ route('perfil.index') }}">Mi Perfil</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="margin-top: 8px;">
                    @csrf
                    <button type="submit" class="btn btn-ghost" style="width: 100%;">Cerrar Sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="margin-top: 8px;">Crear Cuenta</a>
            @endauth
        </div>
    </div>

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
    </script>
    @stack('scripts')
</body>
</html>
