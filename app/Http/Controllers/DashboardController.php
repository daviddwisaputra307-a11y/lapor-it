<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\USERLOG_ROLES; // Pastikan Model ini di-import

class DashboardController extends Controller
{
    // Fungsi pembantu (Helper) agar tidak menulis kode yang sama berulang kali
    private function getUserRole()
    {
        $uslognm = auth()->user()->USLOGNM ?? null;
        // Ambil role dari tabel USERLOG_ROLES sesuai permintaan senior
        return USERLOG_ROLES::where('USERLOGNM', $uslognm)->value('USERLOG_ROLES') ?? 'user';
    }

    public function index()
    {
        $role = $this->getUserRole();

        if ($role == 'admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($role == 'teknisi') {
            return redirect()->route('dashboard.teknisi');
        } elseif ($role == 'user') {
            return redirect()->route('dashboard.user');
        }
    }

    public function admin()
    {
        if ($this->getUserRole() !== 'admin') {
            return redirect()->route('dashboard'); // Lempar ke index jika bukan admin
        }
        return view('dashboard.admin');
    }

    public function teknisi()
    {
        $user = auth()->user();
        $uslognm = trim($user->USLOGNM); // 'teknisi 2'

        // 1. Ambil role (Gunakan str_contains agar role 'teknisi 2' tetap lolos)
        $role = \App\Models\USERLOG_ROLES::where('USERLOGNM', $uslognm)->value('USERLOG_ROLES');

        if (!$role || !str_contains(strtolower($role), 'teknisi')) {
            return redirect()->route('dashboard');
        }

        // 2. QUERY UTAMA: Gunakan Closure untuk mengelompokkan WHERE (A OR B)
        $tickets = \App\Models\Ticket::where(function($query) use ($uslognm, $user) {
                        $query->where('teknisi', 'LIKE', '%' . $uslognm . '%') // Cari penugasan
                            ->orWhere('user_id', $user->id);                 // Cari laporan pribadi
                    })
                    ->latest()
                    ->take(10)
                    ->get();

        // 3. STATISTIK: Cari berdasarkan NAMA STRING
        // Kita gunakan LIKE agar lebih aman terhadap spasi/tipe data SQL Server
        $baseQuery = \App\Models\Ticket::where('teknisi', 'LIKE', '%' . $uslognm . '%');

        $total = (clone $baseQuery)->count();
        $open  = (clone $baseQuery)->where('status', 'Open')->count();
        $prog  = (clone $baseQuery)->whereIn('status', ['On Progress', 'In Progress'])->count();
        $done  = (clone $baseQuery)->where('status', 'Done')->count();

        return view('dashboard.teknisi', compact('tickets', 'total', 'open', 'prog', 'done'));
    }

    public function user()
    {
        // Untuk user umum tidak perlu pengecekan ketat agar tidak loop
        return view('dashboard.user');
    }
}
