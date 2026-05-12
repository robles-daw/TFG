<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f5f7fb; color: #111827; margin: 0; padding: 24px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 32px; border: 1px solid #e5e7eb;">
        <h1 style="margin-top: 0; font-size: 28px;">Recupera tu contraseña</h1>
        <p>Hola {{ $user->name }},</p>
        <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en Pingu Zapas.</p>
        <p style="margin: 24px 0;">
            <a href="{{ $resetUrl }}" style="display: inline-block; background: #ff6b35; color: #ffffff; text-decoration: none; padding: 14px 22px; border-radius: 10px; font-weight: bold;">
                Crear nueva contraseña
            </a>
        </p>
        <p>Si no has sido tú, puedes ignorar este correo sin hacer nada.</p>
        <p>Por seguridad, este enlace caduca en 60 minutos.</p>
    </div>
</body>
</html>
