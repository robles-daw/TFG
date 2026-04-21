<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Las credenciales no son válidas.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(
            Auth::user()->rol === 'admin' ? route('admin.dashboard') : route('perfil.index')
        );
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'codigo_postal' => ['nullable', 'string', 'max:10'],
            'pais' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            ...$data,
            'pais' => ($data['pais'] ?? 'España') ?: 'España',
            'rol' => 'cliente',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('perfil.index')->with('success', 'Tu cuenta ya está lista.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', 'Sesión cerrada correctamente.');
    }
}
