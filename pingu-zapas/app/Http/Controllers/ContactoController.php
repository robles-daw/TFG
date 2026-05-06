<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageConfirmationMail;
use App\Mail\ContactMessageReceivedMail;
use App\Models\Contacto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactoController extends Controller
{
    public function index(): View
    {
        return view('contactos.contactos');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'asunto' => 'nullable|string|max:255',
            'mensaje' => 'required|string',
        ]);

        if (empty($data['asunto'])) {
            $data['asunto'] = 'Mensaje de contacto';
        }

        $contacto = Contacto::create($data);
        $this->sendContactEmails($contacto);

        return redirect()->back()->with('success', 'Mensaje enviado con exito. Hemos enviado una confirmacion a tu correo.');
    }

    private function sendContactEmails(Contacto $contacto): void
    {
        try {
            $notificationRecipient = config('mail.contact_notification_to');

            if (!empty($notificationRecipient)) {
                Mail::to($notificationRecipient)->send(new ContactMessageReceivedMail($contacto));
            }

            Mail::to($contacto->email)->send(new ContactMessageConfirmationMail($contacto));
        } catch (Throwable $exception) {
            Log::warning('No se pudieron enviar los emails del formulario de contacto.', [
                'contacto_id' => $contacto->id,
                'email' => $contacto->email,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
