<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // If already logged in and user has a valid role, direct to dashboard
        if (Auth::check() && in_array(Auth::user()->role, ['doctora', 'asistente'])) {
            return redirect()->intended('/admin/dashboard');
        }

        return view('login');
    }

    /**
     * Handle the authentication attempt.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $request->has('remember');
        $email = $credentials['email'] ?? '';

        $throttleKey = strtolower($email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Demasiados intentos. Por favor intente de nuevo en {$seconds} segundos.",
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($throttleKey);
            $user = Auth::user();

            // Authorization: Allowed roles
            if (in_array($user->role, ['doctora', 'asistente'])) {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }

            // If not authorized, logout immediately and return error
            Auth::logout();
            return back()->withErrors([
                'email' => 'Acceso denegado: solo el personal autorizado tiene acceso al panel administrativo.',
            ])->onlyInput('email');
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }
}
