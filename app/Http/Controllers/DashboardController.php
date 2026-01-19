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
        $uslognm = Auth::user()->USLOGNM ?? null;
        if (!$uslognm) return redirect()->route('login');

        // Ambil ID teknisi dari USERLOG_ID
        $teknisi = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
        $teknisiId = $teknisi->ID ?? null;

        $total = Ticket::where('teknisi_id', $teknisiId)->count();
        $open  = Ticket::where('teknisi_id', $teknisiId)->where('status', 'Open')->count();
        $prog  = Ticket::where('teknisi_id', $teknisiId)->where('status', 'On Progress')->count();
        $done  = Ticket::where('teknisi_id', $teknisiId)->where('status', 'Done')->count();

        $tickets = Ticket::where('teknisi_id', $teknisiId)->latest()->limit(10)->get();

        return view('dashboard.teknisi', compact('total','open','prog','done','tickets'));
    }

    public function user()
    {
        $uslognm = Auth::user()->USLOGNM ?? null;
        if (!$uslognm) return redirect()->route('login');

        // Ambil ID user dari USERLOG_ID
        $user = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
        $userId = $user->ID ?? null;

        $total = Ticket::where('user_id', $userId)->count();
        $open  = Ticket::where('user_id', $userId)->where('status', 'Open')->count();
        $prog  = Ticket::where('user_id', $userId)->where('status', 'On Progress')->count();
        $done  = Ticket::where('user_id', $userId)->where('status', 'Done')->count();

        $tickets = Ticket::where('user_id', $userId)->latest()->limit(10)->get();

        return view('dashboard.user', compact('total','open','prog','done','tickets'));
    }
}
