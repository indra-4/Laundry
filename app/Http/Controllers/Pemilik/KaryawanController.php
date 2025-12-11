<?php
// ========================================
// FILE: app/Http/Controllers/Pemilik/KaryawanController.php
// ========================================

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = User::whereIn('role', ['karyawan', 'kurir'])
            ->latest()
            ->paginate(15);
        
        return view('pemilik.karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('pemilik.karyawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'role' => 'required|in:karyawan,kurir',
        ]);

        // User model has 'hashed' cast, so it will auto-hash the password
        $validated['is_active'] = true;

        User::create($validated);

        return redirect()->route('pemilik.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $karyawan = User::whereIn('role', ['karyawan', 'kurir'])->findOrFail($id);
        return view('pemilik.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = User::whereIn('role', ['karyawan', 'kurir'])->findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'role' => 'required|in:karyawan,kurir',
            'is_active' => 'boolean',
        ]);

        // User model has 'hashed' cast, so it will auto-hash the password if provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $karyawan->update($validated);

        return redirect()->route('pemilik.karyawan.index')
            ->with('success', 'Data karyawan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $karyawan = User::whereIn('role', ['karyawan', 'kurir'])->findOrFail($id);
        $karyawan->delete();

        return redirect()->route('pemilik.karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus!');
    }
}