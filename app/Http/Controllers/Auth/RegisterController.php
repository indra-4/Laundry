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
            'role' => 'required|in:pelanggan,karyawan,kurir,pemilik',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => $validated['password'], // User model has 'hashed' cast, so it will auto-hash
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        Auth::login($user);

        // Redirect based on role
        $roleRoutes = [
            'pelanggan' => 'pelanggan.dashboard',
            'karyawan' => 'karyawan.dashboard',
            'kurir' => 'kurir.dashboard',
            'pemilik' => 'pemilik.dashboard',
        ];

        $redirectRoute = $roleRoutes[$validated['role']] ?? 'pelanggan.dashboard';

        return redirect()->route($redirectRoute)->with('success', 'Registrasi berhasil! Selamat datang di Awan Laundry.');
    }
}