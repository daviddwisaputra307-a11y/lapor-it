<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        // daftar teknisi sementara (nanti bisa ambil dari tabel teknisi)
        $teknisiList = ['Rizky', 'Agus', 'Budi', 'Dina', 'Teknisi A'];

        return view('admin.tickets.show', compact('ticket', 'teknisiList'));
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $request->validate([
            'teknisi' => 'nullable|string|max:100',
        ]);

        $ticket->teknisi = $request->teknisi; // kolom teknisi (string)
        $ticket->save();

        return redirect()
            ->route('admin.tickets.show', $ticket->id)
            ->with('success', 'Teknisi berhasil disimpan.');
    }

    public function status(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|string|max:50',
            'prioritas' => 'nullable|string|max:50',
        ]);

        $ticket->status = $request->status;
        $ticket->prioritas = $request->prioritas;
        $ticket->save();

        return redirect()
            ->route('admin.tickets.show', $ticket->id)
            ->with('success', 'Status/Prioritas berhasil diupdate.');
    }
}
