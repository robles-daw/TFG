@extends('layout.master')

@section('title', 'Editar Perfil | Pingu Zapas')

@section('content')
    <div class="container" style="max-width: 800px;">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Perfil</h1>
                <p class="page-subtitle">Actualiza tus datos personales y de envío.</p>
            </div>
        </div>

        <form action="{{ route('perfil.update') }}" method="POST" class="panel" style="padding: 32px;">
            @csrf
            @method('PUT')

            <div class="form-stack">
                <div>
                    <h3 style="font-size: 1.1rem; margin-bottom: 20px; color: var(--accent); border-bottom: 1px solid var(--line); padding-bottom: 10px;">
                        <i class="fas fa-user"></i> Datos Personales
                    </h3>
                    <div class="field" style="margin-bottom: 16px;">
                        <label for="name">Nombre Completo</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="field">
                        <label for="email">Email (No editable)</label>
                        <input type="email" id="email" value="{{ $user->email }}" disabled style="opacity: 0.6; cursor: not-allowed;">
                    </div>
                </div>

                <div style="margin-top: 32px;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 20px; color: var(--accent); border-bottom: 1px solid var(--line); padding-bottom: 10px;">
                        <i class="fas fa-truck"></i> Datos de Envío
                    </h3>
                    <div class="field" style="margin-bottom: 16px;">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $user->direccion) }}" placeholder="Calle, número, piso...">
                    </div>
                    
                    <div class="grid-2" style="gap: 16px; margin-bottom: 16px;">
                        <div class="field">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" id="ciudad" name="ciudad" value="{{ old('ciudad', $user->ciudad) }}">
                        </div>
                        <div class="field">
                            <label for="codigo_postal">Código Postal</label>
                            <input type="text" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal', $user->codigo_postal) }}">
                        </div>
                    </div>

                    <div class="grid-2" style="gap: 16px;">
                        <div class="field">
                            <label for="pais">País</label>
                            <input type="text" id="pais" name="pais" value="{{ old('pais', $user->pais) }}">
                        </div>
                        <div class="field">
                            <label for="telefono">Teléfono de Contacto</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $user->telefono) }}">
                        </div>
                    </div>
                </div>

                <div style="margin-top: 40px; display: flex; gap: 12px;">
                    <button type="submit" class="btn btn-primary" style="flex: 2;">Guardar Cambios</button>
                    <a href="{{ route('perfil.index') }}" class="btn btn-ghost" style="flex: 1;">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
@endsection
