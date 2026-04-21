<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = Auth::user()->load([
            'pedidos' => fn ($query) => $query->with('items.zapatilla')->latest(),
        ]);

        return view('perfil.index', compact('user'));
    }
}
