<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        // list teknisi contoh (nanti bisa ambil dari tabel users/pegawai)
        $teknisiList = ['Rizky', 'Agus', 'Budi', 'Dina', 'Teknisi A'];

        return view('admin.tickets.show', compact('ticket', 'teknisiList'));
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $request->validate([
            'teknisi' => 'required|string|max:100',
        ]);

        $ticket->teknisi = $request->teknisi;
        $ticket->save();

        return back()->with('success', 'Teknisi berhasil di-assign.');
    }

    public function status(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:Open,On Progress,Done,Cancel',
            'prioritas' => 'nullable|in:Low,Medium,High,Urgent',
        ]);

        $ticket->status = $request->status;

        if ($request->filled('prioritas')) {
            $ticket->prioritas = $request->prioritas;
        }

        $ticket->save();

        return back()->with('success', 'Status/prioritas berhasil diupdate.');
    }
}
