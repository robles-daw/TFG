@extends('layout.master')

@section('title', 'Registro | Pingu Zapas')

@section('content')
    <div class="container auth-shell">
        <div class="auth-card">
            <h1 class="page-title" style="font-size: 2.4rem;">Crear cuenta</h1>
            <p class="page-subtitle">Registro básico por BD con datos de envio opcionales.</p>

            <form method="POST" action="{{ route('register.store') }}" class="form-stack">
                @csrf
                <div class="grid-2">
                    <div class="field">
                        <label for="name">Nombre</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="grid-2">
                    <div class="field">
                        <label for="password">Contrasena</label>
                        <input id="password" type="password" name="password" required>
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Confirmar contrasena</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required>
                    </div>
                </div>
                <div class="grid-2">
                    <div class="field">
                        <label for="telefono">Telefono</label>
                        <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}">
                    </div>
                    <div class="field">
                        <label for="ciudad">Ciudad</label>
                        <input id="ciudad" type="text" name="ciudad" value="{{ old('ciudad') }}">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="field">
                        <label for="codigo_postal">Codigo postal</label>
                        <input id="codigo_postal" type="text" name="codigo_postal" value="{{ old('codigo_postal') }}">
                    </div>
                    <div class="field">
                        <label for="pais">Pais</label>
                        <input id="pais" type="text" name="pais" value="{{ old('pais', 'España') }}">
                    </div>
                </div>
                <div class="field">
                    <label for="direccion">Direccion</label>
                    <textarea id="direccion" name="direccion">{{ old('direccion') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Crear cuenta</button>
            </form>
        </div>
    </div>
@endsection
