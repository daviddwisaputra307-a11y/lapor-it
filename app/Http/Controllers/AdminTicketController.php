<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    //public function __construct()
    //{
    //    $this->middleware(['auth', 'role:admin']);
    //}

    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $teknisiUsernames = \App\Models\USERLOG_ROLES::where('USERLOG_ROLES', 'LIKE', 'teknisi%')->pluck('USERLOGNM'); 
        $teknisiList = \App\Models\USERLOG_ID::whereIn('USERLOGNM', $teknisiUsernames)->get();

        return view('admin.tickets.show', compact('ticket', 'teknisiList'));
    }

    public function assign(Request $request, Ticket $ticket)
    {
        // 1. Validasi sederhana saja karena yang dikirim adalah string nama teknisi
        $request->validate([
            'teknisi_id' => 'required|string', 
        ]);

        // 2. Langsung simpan nilai 'teknisi_id' (yang isinya "teknisi 2") ke kolom 'teknisi'
        $ticket->teknisi = $request->teknisi_id; 
        
        // 3. Simpan ke database
        if ($ticket->save()) {
            return redirect()
                ->route('admin.tickets.show', $ticket->id)
                ->with('success', 'Teknisi ' . $request->teknisi_id . ' berhasil ditugaskan.');
        }

        return redirect()->back()->with('error', 'Gagal menyimpan data.');
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
