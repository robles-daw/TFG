@extends('layout.master')

@section('title', 'Nueva contrasena | Pingu Zapas')

@section('content')
    <div class="container auth-shell">
        <div class="auth-card">
            <h1 class="page-title" style="font-size: 2.4rem;">Crear nueva contrasena</h1>
            <p class="page-subtitle">Elige una contrasena nueva para volver a entrar en tu cuenta.</p>

            <form method="POST" action="{{ route('password.update') }}" class="form-stack">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required>
                </div>

                <div class="field">
                    <label for="password">Nueva contrasena</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirmar contrasena</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar nueva contrasena</button>
            </form>
        </div>
    </div>
@endsection
