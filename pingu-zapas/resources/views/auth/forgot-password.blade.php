@extends('layout.master')

@section('title', 'Recuperar contrasena | Pingu Zapas')

@section('content')
    <div class="container auth-shell">
        <div class="auth-card">
            <h1 class="page-title" style="font-size: 2.4rem;">Recuperar contrasena</h1>
            <p class="page-subtitle">Introduce tu correo y te enviaremos un enlace para crear una nueva contrasena.</p>

            <form method="POST" action="{{ route('password.email') }}" class="form-stack">
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Enviar enlace de recuperacion</button>
                <a href="{{ route('login') }}" class="btn btn-ghost" style="text-align: center;">Volver al login</a>
            </form>
        </div>
    </div>
@endsection
