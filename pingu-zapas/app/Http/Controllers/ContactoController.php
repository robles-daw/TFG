<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        Contacto::create($data);

        return redirect()->back()->with('success', '¡Mensaje enviado con éxito! Nos pondremos en contacto contigo pronto.');
    }
}
