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
    // ambil semua ticket terbaru dulu
    $tickets = Ticket::orderBy('created_at', 'desc')->get();

    return view('tickets.index', compact('tickets'));
}

public function show(Ticket $ticket)
{
    return view('tickets.show', compact('ticket'));
}

    public function create()
    {
        // Ambil lokasi/unit kerja dari SQL Server (default connection = sqlsrv)
        $bagians = DB::table('dbo.BAGIAN')
            ->select('KODEBAGIAN', 'NAMABAGIAN')
            ->orderBy('NAMABAGIAN')
            ->get();

        return view('tickets.create', compact('bagians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'lokasi' => ['required', 'string'], // ini KODEBAGIAN dari dropdown
        ]);

        Ticket::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'], // simpan KODEBAGIAN
            'prioritas' => 'Low',
            'status' => 'Open',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Laporan berhasil dikirim');
    }
    public function indexrole()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            // 1. ADMIN: Melihat SEMUA tiket (untuk pengawasan)
            $tickets = \App\Models\Ticket::with('user')->latest()->get();

        } elseif ($user->role == 'teknisi') {
            // 2. TEKNISI: Hanya melihat tiket yang DITUGASKAN kepadanya
            $tickets = \App\Models\Ticket::with('user')
                            ->where('teknisi_id', $user->id) // Filter berdasarkan ID Teknisi
                            ->latest()
                            ->get();

        } else {
            // 3. USER: Hanya melihat tiket buatan SENDIRI
            $tickets = \App\Models\Ticket::with('user')
                            ->where('user_id', $user->id)
                            ->latest()
                            ->get();
        }

        return view('dashboard', compact('tickets'));
    }
}
