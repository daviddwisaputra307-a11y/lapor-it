<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $uslognm = Auth::user()->USLOGNM ?? null;
        $user = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
        $userId = $user?->ID;

        if (!$userId) {
            return back()->with('error', 'User tidak ditemukan di USERLOG_ID');
        }

        $tickets = Ticket::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tickets.index', compact('tickets'));
    }

    // TAMBAHKAN FUNGSI INI UNTUK MENGATASI ERROR
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function editStatus(Ticket $ticket)
    {
        $user = auth()->user();
        $uslognm = $user->USLOGNM ?? null;
        $userData = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
        $userId = $userData?->ID;

        $isOwner = ($ticket->user_id == $userId);
        $isTeknisi = (trim($ticket->teknisi) == trim($uslognm) || $ticket->teknisi_id == $userId);

        if (!$isOwner && !$isTeknisi) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        return view('tickets.edit', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $user = auth()->user();
        $uslognm = $user->USLOGNM ?? null;
        $userData = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
        $userId = $userData?->ID;

        $isOwner = ($ticket->user_id == $userId);
        $isTeknisi = (trim($ticket->teknisi) == trim($uslognm) || $ticket->teknisi_id == $userId);

        if (!$isOwner && !$isTeknisi) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|string|in:Open,On Progress,Done,Cancel',
        ]);

        $ticket->update(['status' => $request->status]);

        if ($isTeknisi) {
            return redirect()->route('dashboard.teknisi')->with('success', 'Status diperbarui.');
        }

        return redirect()->route('tickets.index')->with('success', 'Status diperbarui.');
    }

    public function create()
    {
        $bagians = DB::table('dbo.BAGIAN')
            ->select('KODEBAGIAN', 'NAMABAGIAN')
            ->orderBy('NAMABAGIAN')
            ->get();

        return view('tickets.create', compact('bagians'));
    }
}