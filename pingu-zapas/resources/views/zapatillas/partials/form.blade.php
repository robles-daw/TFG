<div class="admin-form-section panel">
    <h3><i class="fas fa-info-circle"></i> Información Básica</h3>
    <div class="grid-2">
        <div class="field">
            <label for="categoria_id">Categoría</label>
            <select id="categoria_id" name="categoria_id" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(old('categoria_id', $zapatilla->categoria_id ?? '') == $categoria->id)>{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="nombre">Nombre del Producto</label>
            <input id="nombre" type="text" name="nombre" value="{{ old('nombre', $zapatilla->nombre ?? '') }}" placeholder="Ej: Astra Loop One" required>
        </div>
    </div>
    <div class="grid-2">
        <div class="field">
            <label for="marca">Marca</label>
            <input id="marca" type="text" name="marca" value="{{ old('marca', $zapatilla->marca ?? '') }}" placeholder="Ej: Astra">
        </div>
        <div class="field">
            <label for="modelo">Modelo</label>
            <input id="modelo" type="text" name="modelo" value="{{ old('modelo', $zapatilla->modelo ?? '') }}" placeholder="Ej: Loop">
        </div>
    </div>
</div>

<div class="admin-form-section panel">
    <h3><i class="fas fa-euro-sign"></i> Precio y Visibilidad</h3>
    <div class="grid-2">
        <div class="field">
            <label for="precio">Precio (€)</label>
            <input id="precio" type="number" step="0.01" name="precio" value="{{ old('precio', $zapatilla->precio ?? '') }}" required>
        </div>
        <div class="field" style="justify-content: center; display: flex; flex-direction: column; gap: 12px;">
            <label class="checkbox-row" style="cursor: pointer;">
                <input type="checkbox" name="activo" value="1" @checked(old('activo', $zapatilla->activo ?? true))>
                <span>Producto visible en tienda</span>
            </label>
            <label class="checkbox-row" style="cursor: pointer;">
                <input type="checkbox" name="destacado" value="1" @checked(old('destacado', $zapatilla->destacado ?? false))>
                <span>Marcar como destacado 🔥</span>
            </label>
        </div>
    </div>
</div>

<div class="admin-form-section panel">
    <h3><i class="fas fa-image"></i> Multimedia y Detalles</h3>
    <div class="grid-2">
        <div class="field">
            <label for="imagen_principal_file">Imagen Principal (Subir desde local)</label>
            <input id="imagen_principal_file" type="file" name="imagen_principal_file" accept="image/*">
            <p class="muted" style="margin-top: 4px; font-size: 0.85rem;">Formatos aceptados: JPG, PNG, WEBP. Máx: 2MB.</p>
        </div>
        <div class="field">
            <label for="imagen_principal">O usar URL externa</label>
            <input id="imagen_principal" type="text" name="imagen_principal" value="{{ old('imagen_principal', $zapatilla->imagen_principal ?? '') }}" placeholder="https://...">
        </div>
    </div>

    @if(isset($zapatilla) && $zapatilla->imagen_principal)
        <div style="margin: 12px 0;">
            <p class="muted" style="font-size: 0.9rem; margin-bottom: 8px;">Imagen actual:</p>
            <img src="{{ $zapatilla->main_image_url }}" class="admin-thumb" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid var(--line);">
        </div>
    @endif

    <div class="grid-2" style="margin-top: 24px;">
        <div class="field">
            <label for="imagenes_extra_files">Imágenes Adicionales (Subir varias)</label>
            <input id="imagenes_extra_files" type="file" name="imagenes_extra_files[]" multiple accept="image/*">
        </div>
        <div class="field">
            <label for="imagenes_extra">O añadir URLs adicionales (una por línea)</label>
            <textarea id="imagenes_extra" name="imagenes_extra" placeholder="https://...&#10;https://...">{{ old('imagenes_extra', isset($zapatilla) ? implode("\n", $zapatilla->imagenes_extra ?? []) : '') }}</textarea>
        </div>
    </div>

    @if(isset($zapatilla) && !empty($zapatilla->imagenes_extra))
        <div style="margin-top: 12px;">
            <p class="muted" style="font-size: 0.9rem; margin-bottom: 8px;">Galería actual:</p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @foreach($zapatilla->extra_image_urls as $url)
                    <img src="{{ $url }}" class="admin-thumb" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid var(--line);">
                @endforeach
            </div>
        </div>
    @endif

    <div class="field" style="margin-top: 24px;">
        <label for="descripcion">Descripción del Producto</label>
        <textarea id="descripcion" name="descripcion" placeholder="Escribe los detalles del producto...">{{ old('descripcion', $zapatilla->descripcion ?? '') }}</textarea>
    </div>
</div>

<div class="inline-actions" style="margin-top: 24px;">
    <button class="btn btn-primary" type="submit">
        <i class="fas fa-save"></i> Guardar Cambios
    </button>
    <a href="{{ route('admin.zapatillas.index') }}" class="btn btn-ghost">Cancelar</a>
</div>
