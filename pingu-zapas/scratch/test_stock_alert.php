<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\Zapatilla;
use App\Models\TallaStock;
use App\Models\StockAlertSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$z = Zapatilla::first();
if (!$z) {
    echo "No hay zapatillas en la BD.\n";
    exit;
}

$ts = $z->tallasStock()->first();
if (!$ts) {
    echo "No hay tallas para la zapatilla.\n";
    exit;
}

echo "Zapatilla: {$z->nombre}, Talla: {$ts->talla}, Stock actual: {$ts->stock}\n";

// Asegurar stock 0
$ts->update(['stock' => 0]);
echo "Stock puesto a 0.\n";

$u = User::first();
StockAlertSubscription::updateOrCreate(
    ['user_id' => $u->id, 'zapatilla_id' => $z->id, 'talla' => $ts->talla],
    ['email' => $u->email]
);
echo "Suscripción creada para {$u->email}.\n";

echo "Reponiendo stock a 5...\n";
$ts->update(['stock' => 5]);

echo "Verificando log...\n";
$log = file_get_contents(storage_path('logs/laravel.log'));
if (str_contains($log, 'StockAvailableMail')) {
    echo "¡EXITO! El correo se ha registrado en el log.\n";
} else {
    echo "ERROR: No se encontró el correo en el log.\n";
}
