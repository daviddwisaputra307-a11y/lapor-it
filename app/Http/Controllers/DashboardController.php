<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $role = $user->role ?? 'user'; 

        if (($user->role ?? '') === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        if (($user->role ?? '') === 'teknisi') {
            return redirect()->route('dashboard.teknisi');
        }

        return redirect()->route('dashboard.user');
    }

    public function admin()
    {
        $total = Ticket::count();
        $open  = Ticket::where('status', 'Open')->count();
        $prog  = Ticket::where('status', 'On Progress')->count();
        $done  = Ticket::where('status', 'Done')->count();

        $notifCount = Ticket::where('status','Open')->count();

        return view('dashboard.admin', compact('total','open','prog','done','notifCount'));
    }

    public function teknisi()
    {
        $userId = Auth::id();

        // kalau belum ada teknisi_id di tabel tickets, ganti/skip bagian ini
        $total = Ticket::where('teknisi_id', $userId)->count();
        $open  = Ticket::where('teknisi_id', $userId)->where('status', 'Open')->count();
        $prog  = Ticket::where('teknisi_id', $userId)->where('status', 'On Progress')->count();
        $done  = Ticket::where('teknisi_id', $userId)->where('status', 'Done')->count();

        $tickets = Ticket::where('teknisi_id', $userId)->latest()->limit(10)->get();

        return view('dashboard.teknisi', compact('total','open','prog','done','tickets'));
    }

    public function user()
    {
        $userId = Auth::id();

        $total = Ticket::where('user_id', $userId)->count();
        $open  = Ticket::where('user_id', $userId)->where('status', 'Open')->count();
        $prog  = Ticket::where('user_id', $userId)->where('status', 'On Progress')->count();
        $done  = Ticket::where('user_id', $userId)->where('status', 'Done')->count();

        $tickets = Ticket::where('user_id', $userId)->latest()->limit(10)->get();

        return view('dashboard.user', compact('total','open','prog','done','tickets'));
    }
}
