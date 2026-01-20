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
            'lokasi' => ['required', 'string'],
        ]);

        $uslognm = Auth::user()->USLOGNM ?? null;
        $user = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
        $userId = $user->ID ?? null;

        Ticket::create([
            'user_id' => $userId,
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'prioritas' => 'Low',
            'status' => 'Open',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Laporan berhasil dikirim');
    }

    public function editStatus(Ticket $ticket)
    {
        $user = auth()->user();
        $uslognm = $user->USLOGNM ?? null;
        $userData = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
        $userId = $userData?->ID;

        // Cek apakah dia pemilik tiket atau teknisi yang ditugaskan
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
            'status' => 'required|string|in:Open,On Progress,Done,Cancel,open,closed',
        ]);

        $ticket->update([
            'status' => $request->status,
        ]);

        // Jika teknisi, kembali ke dashboard teknisi. Jika user, ke riwayat tiket.
        if ($isTeknisi) {
            return redirect()->route('dashboard.teknisi')->with('success', 'Status diperbarui.');
        }

        return redirect()->route('tickets.index')->with('success', 'Status diperbarui.');
    }

    public function indexrole()
    {
        $user = auth()->user();
        $uslognm = $user->USLOGNM ?? null;
        $userData = \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first();
        $userId = $userData->ID ?? null;

        if ($user->role == 'admin') {
            $tickets = \App\Models\Ticket::with('user')->latest()->get();
        } elseif ($user->role == 'teknisi') {
            $tickets = \App\Models\Ticket::with('user')
                            ->where('teknisi_id', $userId)
                            ->latest()
                            ->get();
        } else {
            $tickets = \App\Models\Ticket::with('user')
                            ->where('user_id', $userId)
                            ->latest()
                            ->get();
        }

        return view('dashboard', compact('tickets'));
    }
}