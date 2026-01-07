<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Jangan lupa ini buat password

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // --- TAMBAHAN BARU ---

    // 1. Menampilkan Form
    public function create()
    {
        return view('admin.users.create');
    }

    // 2. Menyimpan Data ke Database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required',
            'unit_kerja' => 'required',
        ]);

        // Simpan User Baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role' => $request->role,
            'unit_kerja' => $request->unit_kerja,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // 3. Tampilkan Form Edit
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // 4. Simpan Perubahan (Update)
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Kecualikan email user ini sendiri
            'role' => 'required',
            'unit_kerja' => 'required',
        ]);

        // Update data dasar
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'unit_kerja' => $request->unit_kerja,
        ]);

        // Update password HANYA JIKA diisi
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 5. Hapus User (Delete)
    public function destroy(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}