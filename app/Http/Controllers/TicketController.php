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

        $uslognm = Auth::user()->USLOGNM ?? null;
        $user = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
        $userId = $user->ID ?? null;
        Ticket::create([
            'user_id' => $userId,
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
            $uslognm = $user->USLOGNM ?? null;
            $teknisi = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
            $teknisiId = $teknisi->ID ?? null;
            $tickets = \App\Models\Ticket::with('user')
                            ->where('teknisi_id', $teknisiId) // Filter berdasarkan ID Teknisi
                            ->latest()
                            ->get();

        } else {
            // 3. USER: Hanya melihat tiket buatan SENDIRI
            $uslognm = $user->USLOGNM ?? null;
            $userData = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
            $userId = $userData->ID ?? null;
            $tickets = \App\Models\Ticket::with('user')
                            ->where('user_id', $userId)
                            ->latest()
                            ->get();
        }

        return view('dashboard', compact('tickets'));
    }


public function editStatus(Ticket $ticket)
{
    // biar user cuma bisa edit tiket dia sendiri
    $uslognm = Auth::user()->USLOGNM ?? null;
    $user = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
    $userId = $user?->ID;

    if ($ticket->user_id != $userId) {
        abort(403);
    }

    return view('tickets.edit', compact('ticket'));
}

public function updateStatus(Request $request, Ticket $ticket)

{
    $uslognm = Auth::user()->USLOGNM ?? null;
    $user = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
    $userId = $user?->ID;

    if ($ticket->user_id != $userId) {
        abort(403);
    }

    $request->validate([
        'status' => 'required|in:open,closed',
    ]);

    $ticket->update([
        'status' => $request->status,
    ]);

    return redirect()->route('tickets.index')->with('success', 'Status berhasil diupdate');

    }

}
