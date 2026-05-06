<div class="admin-form-section panel">
    <h3><i class="fas fa-heading"></i> Informacion de la Noticia</h3>
    <div class="field">
        <label for="titulo">Titulo de la Noticia</label>
        <input id="titulo" type="text" name="titulo" value="{{ old('titulo', $noticia->titulo ?? '') }}" placeholder="Ej: Nueva rotacion urbana para primavera" required>
    </div>

    <div class="grid-2" style="margin-top: 14px;">
        <div class="field">
            <label for="categoria">Categoria</label>
            <select id="categoria" name="categoria" required>
                @foreach(['lanzamiento', 'oferta', 'evento', 'general'] as $cat)
                    <option value="{{ $cat }}" @selected(old('categoria', $noticia->categoria ?? '') === $cat)>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="imagen_portada_file">Imagen Portada (Subir local)</label>
            <input id="imagen_portada_file" type="file" name="imagen_portada_file" accept="image/*">
        </div>
    </div>

    <div class="field" style="margin-top: 14px;">
        <label for="imagen_portada">O usar URL externa</label>
        <input id="imagen_portada" type="text" name="imagen_portada" value="{{ old('imagen_portada', $noticia->imagen_portada ?? '') }}" placeholder="https://...">
    </div>

    @if(isset($noticia) && $noticia->imagen_portada)
        <div style="margin: 12px 0;">
            <p class="muted" style="font-size: 0.9rem; margin-bottom: 8px;">Imagen actual:</p>
            <img src="{{ $noticia->image_url }}" class="admin-thumb" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid var(--line);">
        </div>
    @endif
</div>

<div class="admin-form-section panel">
    <h3><i class="fas fa-pen-nib"></i> Contenido</h3>
    <div class="field">
        <label for="resumen">Resumen Corto (Entradilla)</label>
        <textarea id="resumen" name="resumen" style="min-height: 80px;" placeholder="Breve descripcion para los listados...">{{ old('resumen', $noticia->resumen ?? '') }}</textarea>
    </div>
    <div class="field" style="margin-top: 14px;">
        <label for="contenido-editor">Cuerpo de la Noticia</label>
        <input id="contenido" type="hidden" name="contenido" value="{{ old('contenido', $noticia->contenido ?? '') }}">
        <div id="contenido-editor" class="quill-editor"></div>
        <p class="muted" style="margin-top: 8px; font-size: 0.9rem;">Puedes dar formato al texto, crear listas, enlaces y citas.</p>
    </div>
</div>

<div class="admin-form-section panel">
    <h3><i class="fas fa-bullhorn"></i> Ajustes de Publicacion</h3>
    <div class="grid-2">
        <label class="checkbox-row" style="cursor: pointer;">
            <input type="checkbox" name="publicado" value="1" @checked(old('publicado', $noticia->publicado ?? false))>
            <span>Publicar noticia inmediatamente</span>
        </label>
        <label class="checkbox-row" style="cursor: pointer;">
            <input type="checkbox" name="destacado" value="1" @checked(old('destacado', $noticia->destacado ?? false))>
            <span>Fijar en la parte superior (Destacado)</span>
        </label>
    </div>
</div>

<div class="inline-actions" style="margin-top: 24px;">
    <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Guardar Noticia</button>
    <a href="{{ route('admin.noticias.index') }}" class="btn btn-ghost">Cancelar</a>
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
    <style>
        .quill-editor {
            min-height: 280px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--line);
            border-radius: 16px;
            overflow: hidden;
        }

        .quill-editor .ql-toolbar.ql-snow {
            border: 0;
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.02);
        }

        .quill-editor .ql-container.ql-snow {
            border: 0;
            font-family: inherit;
            font-size: 1rem;
            min-height: 220px;
        }

        .quill-editor .ql-editor {
            min-height: 220px;
            color: var(--text);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const contenidoInput = document.getElementById('contenido');
            const editorElement = document.getElementById('contenido-editor');

            if (!contenidoInput || !editorElement) {
                return;
            }

            const quill = new Quill(editorElement, {
                theme: 'snow',
                placeholder: 'Escribe el articulo completo aqui...',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['blockquote', 'link'],
                        ['clean']
                    ]
                }
            });

            quill.root.innerHTML = contenidoInput.value || '';

            const syncContenido = () => {
                const html = quill.root.innerHTML;
                contenidoInput.value = html === '<p><br></p>' ? '' : html;
            };

            quill.on('text-change', syncContenido);

            const form = editorElement.closest('form');
            if (form) {
                form.addEventListener('submit', syncContenido);
            }
        });
    </script>
@endpush
