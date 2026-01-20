<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTicketController extends Controller
{
    public function index()
    {
        // Ganti ->get() menjadi ->paginate(10)
        $tickets = Ticket::with('user')->latest()->paginate(10);
        
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        // Sesuaikan dengan foto Navicat: Tabel USERLOG_ROLES, Kolom USERLOG_ROLES
        $teknisiList = DB::table('USERLOG_ROLES')
            ->where('USERLOG_ROLES', 'LIKE', 'teknisi%')
            ->orderBy('USERLOGNM', 'asc')
            ->get();

        return view('admin.tickets.show', compact('ticket', 'teknisiList'));
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $request->validate([
            'teknisi' => 'required|string',
        ]);

        // Cari ID di tabel USERLOG_ROLES (kolom id huruf kecil sesuai Navicat)
        $teknisiData = DB::table('USERLOG_ROLES')
            ->where('USERLOGNM', $request->teknisi)
            ->first();

        $ticket->update([
            'teknisi'    => $request->teknisi,
            'teknisi_id' => $teknisiData->id ?? null, 
            'status'     => 'On Progress',
        ]);

        return redirect()->back()->with('success', 'Teknisi berhasil ditugaskan.');
    }

    // Update Status & Prioritas (Fungsi Status)
    public function status(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status'    => 'required|in:Open,On Progress,Done,Cancel',
            'prioritas' => 'nullable|in:Low,Medium,High,Urgent',
        ]);

        $ticket->update([
            'status'    => $request->status,
            'prioritas' => $request->prioritas,
        ]);

        return redirect()->back()->with('success', 'Status & Prioritas tiket berhasil diperbarui.');
    }
}