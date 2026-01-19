<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class DashboardController extends Controller
{
    // 1. Dashboard Utama (Logika Redirect Otomatis)
    public function index()
    {
        $role = Auth::user()->role;

        if ($role == 'admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($role == 'teknisi') {
            return redirect()->route('dashboard.teknisi');
        } else {
            return redirect()->route('dashboard.user');
        }
    }

    // 2. Halaman Dashboard ADMIN
    public function admin()
    {
        // Pastikan file views/dashboard/admin.blade.php ADA
        // Kalau tidak ada, ganti return view('tickets.index');
        return view('dashboard.admin'); 
    }

    // 3. Halaman Dashboard TEKNISI
    public function teknisi()
    {
        // Pastikan file views/dashboard/teknisi.blade.php ADA
        return view('dashboard.teknisi');
    }

    // 4. Halaman Dashboard USER (Yang Screenshot Putih Tadi)
    public function user()
    {
        // Pastikan file views/dashboard/user.blade.php ADA
        return view('dashboard.user');
    }
}