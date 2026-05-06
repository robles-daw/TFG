<div style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6;">
    <h1 style="font-size: 24px; margin-bottom: 16px;">Tu talla ya vuelve a tener stock</h1>

    <p style="margin: 0 0 12px;">Hola {{ $subscription->user->name }},</p>

    <p style="margin: 0 0 16px;">
        <strong>{{ $subscription->zapatilla->nombre }}</strong> ya vuelve a estar disponible en Pingu Zapas.
    </p>

    <p style="margin: 0 0 20px;">
        Puedes entrar ahora mismo a la ficha del producto para añadirla al carrito antes de que vuelva a agotarse.
    </p>

    <a href="{{ route('zapatillas.show', $subscription->zapatilla) }}"
       style="display: inline-block; padding: 12px 18px; background: #f97316; color: #ffffff; text-decoration: none; border-radius: 10px; font-weight: 700;">
        Ver producto
    </a>
</div>
