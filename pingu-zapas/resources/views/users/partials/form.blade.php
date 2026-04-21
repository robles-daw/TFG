<div class="admin-form-section panel">
    <h3><i class="fas fa-user-circle"></i> Información de Cuenta</h3>
    <div class="grid-2">
        <div class="field">
            <label for="name">Nombre Completo</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="Ej: Juan Pérez" required>
        </div>
        <div class="field">
            <label for="email">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="juan@ejemplo.com" required>
        </div>
    </div>
    <div class="grid-2">
        <div class="field">
            <label for="rol">Rol del Usuario</label>
            <select id="rol" name="rol" required>
                <option value="cliente" @selected(old('rol', $user->rol ?? 'cliente') === 'cliente')>Cliente Estándar</option>
                <option value="admin" @selected(old('rol', $user->rol ?? 'cliente') === 'admin')>Administrador</option>
            </select>
        </div>
        <div class="field">
            <label for="telefono">Teléfono de Contacto</label>
            <input id="telefono" type="text" name="telefono" value="{{ old('telefono', $user->telefono ?? '') }}" placeholder="Ej: 600000000">
        </div>
    </div>
</div>

<div class="admin-form-section panel">
    <h3><i class="fas fa-lock"></i> Seguridad</h3>
    <p class="muted" style="margin-bottom: 12px; font-size: 0.9rem;">
        <i class="fas fa-info-circle"></i> Dejar en blanco para mantener la contraseña actual (si estás editando).
    </p>
    <div class="grid-2">
        <div class="field">
            <label for="password">Nueva Contraseña</label>
            <input id="password" type="password" name="password" placeholder="••••••••">
        </div>
        <div class="field">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••">
        </div>
    </div>
</div>

<div class="admin-form-section panel">
    <h3><i class="fas fa-map-marker-alt"></i> Dirección y Ubicación</h3>
    <div class="grid-2">
        <div class="field">
            <label for="ciudad">Ciudad</label>
            <input id="ciudad" type="text" name="ciudad" value="{{ old('ciudad', $user->ciudad ?? '') }}" placeholder="Ej: Madrid">
        </div>
        <div class="field">
            <label for="codigo_postal">Código Postal</label>
            <input id="codigo_postal" type="text" name="codigo_postal" value="{{ old('codigo_postal', $user->codigo_postal ?? '') }}" placeholder="28001">
        </div>
    </div>
    <div class="field" style="margin-top: 14px;">
        <label for="direccion">Dirección Completa</label>
        <textarea id="direccion" name="direccion" placeholder="Calle, número, piso...">{{ old('direccion', $user->direccion ?? '') }}</textarea>
    </div>
    <div class="field" style="margin-top: 14px;">
        <label for="pais">País</label>
        <input id="pais" type="text" name="pais" value="{{ old('pais', $user->pais ?? 'España') }}">
    </div>
</div>

<div class="inline-actions" style="margin-top: 24px;">
    <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Guardar Usuario</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Cancelar</a>
</div>
