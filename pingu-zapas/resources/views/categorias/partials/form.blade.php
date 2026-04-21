<div class="admin-form-section panel">
    <h3><i class="fas fa-layer-group"></i> Información de Categoría</h3>
    <div class="grid-2">
        <div class="field">
            <label for="nombre">Nombre</label>
            <input id="nombre" type="text" name="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" placeholder="Ej: Running" required>
        </div>
        <div class="field">
            <label for="imagen_file">Imagen (Subir desde local)</label>
            <input id="imagen_file" type="file" name="imagen_file" accept="image/*">
        </div>
    </div>
    <div class="field" style="margin-top: 14px;">
        <label for="imagen">O usar URL externa</label>
        <input id="imagen" type="text" name="imagen" value="{{ old('imagen', $categoria->imagen ?? '') }}" placeholder="https://...">
    </div>

    @if(isset($categoria) && $categoria->imagen)
        <div style="margin: 12px 0;">
            <p class="muted" style="font-size: 0.9rem; margin-bottom: 8px;">Imagen actual:</p>
            <img src="{{ $categoria->image_url }}" class="admin-thumb" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid var(--line);">
        </div>
    @endif

    <div class="field" style="margin-top: 14px;">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" placeholder="Explica brevemente qué define a esta categoría...">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
    </div>
</div>

<div class="inline-actions" style="margin-top: 24px;">
    <button class="btn btn-primary" type="submit">
        <i class="fas fa-save"></i> Guardar Categoría
    </button>
    <a href="{{ route('admin.categorias.index') }}" class="btn btn-ghost">Cancelar</a>
</div>
