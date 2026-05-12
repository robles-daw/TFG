@extends('layout.master')

@section('title', 'Recuperar contraseña | Pingu Zapas')

@section('content')
    <div class="container auth-shell">
        <div class="auth-card">
            <h1 class="page-title" style="font-size: 2.4rem;">Recuperar contraseña</h1>
            <p class="page-subtitle">Introduce tu correo electrónico y te enviaremos un enlace para crear una nueva contraseña.</p>

            <form method="POST" action="{{ route('password.email') }}" class="form-stack">
                @csrf
                <div class="field">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Enviar enlace de recuperación</button>
                <a href="{{ route('login') }}" class="btn btn-ghost" style="text-align: center;">Volver a iniciar sesión</a>
            </form>
        </div>
    </div>
@endsection
