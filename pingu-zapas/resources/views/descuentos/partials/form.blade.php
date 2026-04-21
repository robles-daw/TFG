<div class="admin-form-section panel">
    <h3><i class="fas fa-ticket-alt"></i> Configuración del Cupón</h3>
    <div class="grid-2">
        <div class="field">
            <label for="codigo">Código del Cupón</label>
            <input id="codigo" type="text" name="codigo" value="{{ old('codigo', $descuento->codigo ?? '') }}" placeholder="Ej: VERANO20" style="text-transform: uppercase; font-weight: bold;" required>
        </div>
        <div class="field">
            <label for="tipo">Tipo de Descuento</label>
            <select id="tipo" name="tipo" required>
                @foreach(['porcentaje' => 'Porcentaje (%)', 'fijo' => 'Importe Fijo (€)'] as $val => $label)
                    <option value="{{ $val }}" @selected(old('tipo', $descuento->tipo ?? 'porcentaje') === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid-2">
        <div class="field">
            <label for="valor">Valor del Descuento</label>
            <input id="valor" type="number" step="0.01" name="valor" value="{{ old('valor', $descuento->valor ?? '') }}" placeholder="10.00" required>
        </div>
        <div class="field" style="justify-content: center; display: flex;">
            <label class="checkbox-row" style="cursor: pointer;">
                <input type="checkbox" name="activo" value="1" @checked(old('activo', $descuento->activo ?? true))>
                <span>Cupón activado</span>
            </label>
        </div>
    </div>
</div>

<div class="admin-form-section panel">
    <h3><i class="fas fa-filter"></i> Condiciones de Aplicación</h3>
    <div class="grid-2">
        <div class="field">
            <label for="minimo_pedido">Pedido Mínimo (€)</label>
            <input id="minimo_pedido" type="number" step="0.01" name="minimo_pedido" value="{{ old('minimo_pedido', $descuento->minimo_pedido ?? '') }}" placeholder="0.00">
        </div>
        <div class="field">
            <label for="maximo_descuento">Descuento Máximo (€)</label>
            <input id="maximo_descuento" type="number" step="0.01" name="maximo_descuento" value="{{ old('maximo_descuento', $descuento->maximo_descuento ?? '') }}" placeholder="Sin límite">
        </div>
    </div>
    <div class="field" style="margin-top: 14px;">
        <label for="usos_maximos">Límite Total de Usos</label>
        <input id="usos_maximos" type="number" name="usos_maximos" value="{{ old('usos_maximos', $descuento->usos_maximos ?? '') }}" placeholder="Ej: 100">
    </div>
</div>

<div class="admin-form-section panel">
    <h3><i class="fas fa-calendar-alt"></i> Periodo de Validez</h3>
    <div class="grid-2">
        <div class="field">
            <label for="fecha_inicio">Fecha de Inicio</label>
            <input id="fecha_inicio" type="datetime-local" name="fecha_inicio" value="{{ old('fecha_inicio', isset($descuento?->fecha_inicio) ? $descuento->fecha_inicio->format('Y-m-d\TH:i') : '') }}">
        </div>
        <div class="field">
            <label for="fecha_fin">Fecha de Fin</label>
            <input id="fecha_fin" type="datetime-local" name="fecha_fin" value="{{ old('fecha_fin', isset($descuento?->fecha_fin) ? $descuento->fecha_fin->format('Y-m-d\TH:i') : '') }}">
        </div>
    </div>
</div>

<div class="field" style="margin-bottom: 24px;">
    <label for="descripcion">Descripción (Interna o para Cliente)</label>
    <textarea id="descripcion" name="descripcion" placeholder="Explica el motivo o condiciones de este descuento...">{{ old('descripcion', $descuento->descripcion ?? '') }}</textarea>
</div>

<div class="inline-actions">
    <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Guardar Descuento</button>
    <a href="{{ route('admin.descuentos.index') }}" class="btn btn-ghost">Cancelar</a>
</div>
