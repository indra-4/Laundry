<?php
// ========================================
// FILE: app/Http/Controllers/Auth/LoginController.php
// ========================================

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $throttleKey = Str::lower($request->input('email')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ])->onlyInput('email');
        }

        try {
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                RateLimiter::clear($throttleKey);
                $request->session()->regenerate();

                $user = Auth::user();
                
                // Redirect based on role
                return match($user->role) {
                    'pelanggan' => redirect()->intended(route('pelanggan.dashboard')),
                    'karyawan' => redirect()->intended(route('karyawan.dashboard')),
                    'kurir' => redirect()->intended(route('kurir.dashboard')),
                    'pemilik' => redirect()->intended(route('pemilik.dashboard')),
                    default => redirect()->route('home'),
                };
            }
        } catch (\RuntimeException $e) {
            // Handle password hash errors (e.g., non-bcrypt passwords in database)
            if (str_contains($e->getMessage(), 'Bcrypt algorithm')) {
                return back()->withErrors([
                    'email' => 'Password untuk akun ini perlu direset. Silakan hubungi administrator.',
                ])->onlyInput('email');
            }
            
            // Re-throw if it's a different RuntimeException
            throw $e;
        }

        RateLimiter::hit($throttleKey, 60); // 60 seconds lockout after 5 attempts

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}