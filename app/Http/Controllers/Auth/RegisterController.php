<?php
// ========================================
// FILE: app/Http/Controllers/Auth/RegisterController.php
// ========================================

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => $validated['password'], // User model has 'hashed' cast, so it will auto-hash
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'role' => 'pelanggan', // Hardcoded for security, new users are always customers
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('pelanggan.dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Awan Laundry.');
    }
}