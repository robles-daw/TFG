<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmacion de mensaje enviado</title>
</head>
<body style="margin: 0; padding: 24px; background: #f5f7fb; color: #1f2937; font-family: Arial, Helvetica, sans-serif;">
    <div style="max-width: 720px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 32px; border: 1px solid #e5e7eb;">
        <h1 style="margin-top: 0; font-size: 28px;">Hemos recibido tu mensaje</h1>
        <p>Gracias por contactar con <strong>Pingu Zapas</strong>. Te confirmamos que hemos recibido tu consulta y te responderemos lo antes posible.</p>

        <div style="margin: 24px 0; padding: 16px; background: #f9fafb; border-radius: 12px;">
            <p style="margin: 0 0 8px;"><strong>Nombre:</strong> {{ $contacto->nombre }}</p>
            <p style="margin: 0 0 8px;"><strong>Email:</strong> {{ $contacto->email }}</p>
            <p style="margin: 0;"><strong>Asunto:</strong> {{ $contacto->asunto }}</p>
        </div>

        <h2 style="font-size: 18px;">Copia de tu mensaje</h2>
        <div style="padding: 16px; background: #f9fafb; border-radius: 12px; white-space: pre-line;">{{ $contacto->mensaje }}</div>
    </div>
</body>
</html>
