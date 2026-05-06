<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo mensaje de contacto</title>
</head>
<body style="margin: 0; padding: 24px; background: #f5f7fb; color: #1f2937; font-family: Arial, Helvetica, sans-serif;">
    <div style="max-width: 720px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 32px; border: 1px solid #e5e7eb;">
        <h1 style="margin-top: 0; font-size: 28px;">Nuevo mensaje de contacto</h1>
        <p>Has recibido una nueva consulta desde el formulario web.</p>

        <div style="margin: 24px 0; padding: 16px; background: #f9fafb; border-radius: 12px;">
            <p style="margin: 0 0 8px;"><strong>Nombre:</strong> {{ $contacto->nombre }}</p>
            <p style="margin: 0 0 8px;"><strong>Email:</strong> {{ $contacto->email }}</p>
            <p style="margin: 0 0 8px;"><strong>Telefono:</strong> {{ $contacto->telefono ?: 'No indicado' }}</p>
            <p style="margin: 0;"><strong>Asunto:</strong> {{ $contacto->asunto }}</p>
        </div>

        <h2 style="font-size: 18px;">Mensaje</h2>
        <div style="padding: 16px; background: #f9fafb; border-radius: 12px; white-space: pre-line;">{{ $contacto->mensaje }}</div>
    </div>
</body>
</html>
