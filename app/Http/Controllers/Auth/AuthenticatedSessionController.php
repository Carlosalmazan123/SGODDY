<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
 
     public function store(Request $request)
     {
         $request->validate([
             'email' => ['required', 'email'],
             'password' => ['required'],
         ]);
 
         if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
             throw ValidationException::withMessages([
                 'email' => __('auth.failed'),
             ]);
         }
 
         $request->session()->regenerate();
         /** @var \App\Models\User */
         // Obtener usuario autenticado
         $user = Auth::user();
 
         // Usando Spatie para verificar roles
         if ($user->hasRole('admin')) {
             return redirect()->route('dashboard'); // Ruta del dashboard para admin
         } elseif ($user->hasRole('cliente')) {
             return redirect()->route('welcome'); // Ruta de welcome para cliente
         }
 
         // Redirección por defecto si no tiene rol asignado
         return redirect()->route('welcome');
     }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
