@extends('layout.master')

@section('title', 'Entrar | Pingu Zapas')

@section('content')
    @php
        $cookiesAceptadas = request()->cookie('cookieConsent') === 'accepted';
    @endphp

    <div class="container auth-shell">
        <div class="auth-card">
            <h1 class="page-title" style="font-size: 2.4rem;">Iniciar sesion</h1>
            <p class="page-subtitle">Usa `admin@pinguzapas.com / password` o cualquiera de los usuarios seeded.</p>

            <form method="POST" action="{{ route('login.store') }}" class="form-stack">
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="field">
                    <label for="password">Contrasena</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <div style="display: flex; justify-content: flex-end; margin-top: -6px;">
                    <a href="{{ route('password.request') }}" class="muted" style="font-size: 0.95rem;">He olvidado mi contrasena</a>
                </div>
                <label class="checkbox-row">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember') || $cookiesAceptadas)>
                    <span>Recordarme en este navegador</span>
                </label>
                <p class="muted" style="margin: -6px 0 0; font-size: 0.9rem;">
                    Si aceptaste las cookies, guardaremos tu perfil para no pedirte iniciar sesion en cada visita.
                </p>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </div>
    </div>
@endsection
