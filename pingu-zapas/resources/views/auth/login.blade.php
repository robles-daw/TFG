@extends('layout.master')

@section('title', 'Entrar | Pingu Zapas')

@section('content')
    <div class="container auth-shell">
        <div class="auth-card">
            <h1 class="page-title" style="font-size: 2.4rem;">Iniciar sesion</h1>
            <p class="page-subtitle">Usa `admin@pinguzapas.local / password` o cualquiera de los usuarios seeded.</p>

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
                <label class="checkbox-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Recordarme</span>
                </label>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </div>
    </div>
@endsection
