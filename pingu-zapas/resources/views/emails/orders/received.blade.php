<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo pedido {{ $pedido->numero_pedido }}</title>
</head>
<body style="margin: 0; padding: 24px; background: #f5f7fb; color: #1f2937; font-family: Arial, Helvetica, sans-serif;">
    <div style="max-width: 720px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 32px; border: 1px solid #e5e7eb;">
        <h1 style="margin-top: 0; font-size: 28px;">Nuevo pedido recibido</h1>
        <p>Se ha registrado un nuevo pedido en la tienda con los siguientes datos:</p>

        <div style="margin: 24px 0; padding: 16px; background: #f9fafb; border-radius: 12px;">
            <p style="margin: 0 0 8px;"><strong>Pedido:</strong> {{ $pedido->numero_pedido }}</p>
            <p style="margin: 0 0 8px;"><strong>Cliente:</strong> {{ $pedido->user->name }} ({{ $pedido->user->email }})</p>
            <p style="margin: 0 0 8px;"><strong>Pago:</strong> {{ ucfirst($pedido->metodo_pago) }}</p>
            <p style="margin: 0;"><strong>Total:</strong> {{ number_format($pedido->total, 2) }} €</p>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 12px; border-bottom: 1px solid #e5e7eb;">Producto</th>
                    <th style="text-align: left; padding: 12px; border-bottom: 1px solid #e5e7eb;">Talla</th>
                    <th style="text-align: left; padding: 12px; border-bottom: 1px solid #e5e7eb;">Cantidad</th>
                    <th style="text-align: right; padding: 12px; border-bottom: 1px solid #e5e7eb;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->items as $item)
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #f3f4f6;">{{ $item->zapatilla->nombre }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f3f4f6;">{{ $item->talla }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f3f4f6;">{{ $item->cantidad }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #f3f4f6; text-align: right;">{{ number_format($item->subtotal, 2) }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 style="font-size: 18px;">Envio</h2>
        <p style="margin: 0 0 8px;">{{ $pedido->nombre_envio }}</p>
        <p style="margin: 0 0 8px;">{{ $pedido->direccion_envio }}</p>
        <p style="margin: 0 0 8px;">{{ $pedido->codigo_postal_envio }} {{ $pedido->ciudad_envio }} · {{ $pedido->pais_envio }}</p>
        <p style="margin: 0;">{{ $pedido->telefono_contacto }}</p>
    </div>
</body>
</html>
