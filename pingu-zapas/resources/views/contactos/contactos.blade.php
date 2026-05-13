@extends('layout.master')

@section('title', 'Contacto | Pingu Zapas')

@section('content')
    <div class="container" style="max-width: 1000px; margin-top: 40px;">
        <div class="page-header" style="text-align: center; margin-bottom: 60px;">
            <span class="badge" style="margin-bottom: 16px;">Atención personalizada</span>
            <h1 class="page-title" style="margin-bottom: 12px;">Contacta con Pingu Zapas</h1>
            <p class="muted">Estamos aquí para ayudarte con tallas, pedidos, disponibilidad y cualquier duda sobre nuestros productos.</p>
        </div>

        <div class="grid-2" style="gap: 32px; align-items: start;">
            <div class="panel" style="padding: 40px;">
                <h3 style="margin-top: 0; margin-bottom: 24px; font-size: 1.5rem; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-paper-plane" style="color: var(--accent);"></i>
                    Envíanos tu consulta
                </h3>

                <form action="{{ route('contacto.store') }}" method="POST" class="form-stack">
                    @csrf
                    <div class="field">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre y apellidos" required>
                    </div>

                    <div class="grid-2" style="gap: 16px;">
                        <div class="field">
                            <label for="email">Correo electrónico</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="tucorreo@ejemplo.com" required>
                        </div>
                        <div class="field">
                            <label for="telefono">Teléfono (opcional)</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" placeholder="612 344 567">
                        </div>
                    </div>

                    <div class="field">
                        <label for="mensaje">Mensaje</label>
                        <textarea name="mensaje" id="mensaje" rows="6" placeholder="Cuéntanos cómo podemos ayudarte..." required>{{ old('mensaje') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; height: 52px; font-weight: 700; font-size: 1.1rem; margin-top: 12px;">
                        Enviar mensaje
                    </button>
                </form>
            </div>

            <div style="display: grid; gap: 32px;">
                <div class="panel" style="padding: 32px;">
                    <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.3rem;">Información de contacto</h3>
                    <div class="list-clean">
                        <div style="display: flex; gap: 16px; align-items: center; padding: 12px 0;">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,107,53,0.1); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <strong style="display: block;">Tienda y oficinas</strong>
                                <span class="muted">Calle Almagro, 18. Zaragoza, España.</span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 16px; align-items: center; padding: 12px 0;">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(46,196,182,0.1); color: var(--accent-2); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <strong style="display: block;">Soporte al cliente</strong>
                                <span class="muted">soporte@pinguzapas.com</span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 16px; align-items: center; padding: 12px 0;">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,107,53,0.1); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <strong style="display: block;">WhatsApp Business</strong>
                                <span class="muted">+34 976 123 456</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel" style="overflow: hidden; height: 300px; padding: 0;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2721.2491179065614!2d-0.8905526244191054!3d41.64839597976553!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5914c2c65a9721%3A0xf6b7a037bfbb0528!2sCalle%20de%20Almagro%2C%2050004%20Zaragoza!5e1!3m2!1ses!2ses!4v1778680833913!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
