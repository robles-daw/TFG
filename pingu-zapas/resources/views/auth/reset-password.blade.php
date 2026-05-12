@extends('layout.master')

@section('title', 'Nueva contraseña | Pingu Zapas')

@section('content')
    <div class="container auth-shell">
        <div class="auth-card">
            <h1 class="page-title" style="font-size: 2.4rem;">Crear nueva contraseña</h1>
            <p class="page-subtitle">Introduce una contraseña segura para recuperar el acceso a tu cuenta.</p>

            <form method="POST" action="{{ route('password.update') }}" class="form-stack">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="field">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required>
                </div>

                <div class="field">
                    <label for="password">Nueva contraseña</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirmar nueva contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar contraseña</button>
            </form>
        </div>
    </div>
@endsection
