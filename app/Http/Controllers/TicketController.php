<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\USERLOG_ID; // Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    // --- KHUSUS USER/PELAPOR ---
    public function index()
    {
        $uslognm = auth()->user()->USLOGNM ?? null;

        // Gunakan DB table USERLOG_ROLES sesuai foto Navicat
        $user = DB::table('USERLOG_ROLES')->where('USERLOGNM', $uslognm)->first();
        $userId = $user?->id;

        if (!$userId) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        // Ganti ->get() menjadi ->paginate(10)
        $tickets = Ticket::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
        $user = USERLOG_ID::where('USERLOGNM', $uslognm)->first();

        Ticket::create([
            'user_id'   => $user->ID ?? null,
            'judul'     => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi'    => $validated['lokasi'],
            'prioritas' => 'Low',
            'status'    => 'Open',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Laporan berhasil dikirim');
    }


    // --- KHUSUS ADMIN (Untuk show.blade.php yang Anda kirim) ---
    public function adminShow(Ticket $ticket)
    {
        // Mengambil daftar user yang rolenya mengandung kata 'teknisi'
        // Sesuai permintaan Anda: LIKE teknisi%
        $teknisiList = USERLOG_ID::where('USERLOG_ROLES', 'LIKE', 'teknisi%')
            ->orderBy('USERLOGNM', 'asc')
            ->get();

        return view('admin.tickets.show', compact('ticket', 'teknisiList'));
    }

    // Fungsi untuk Assign Teknisi
    public function assign(Request $request, Ticket $ticket)
    {
        $request->validate([
            'teknisi' => 'required|string',
        ]);

        // Cari data teknisi berdasarkan Nama (USLOGNM) untuk mendapatkan ID-nya
        $teknisiData = USERLOG_ID::where('USERLOGNM', $request->teknisi)->first();

        $ticket->update([
            'teknisi'    => $request->teknisi, // Simpan Nama
            'teknisi_id' => $teknisiData->ID ?? null, // Simpan ID jika ada kolomnya
            'status'     => 'On Progress', // Otomatis ubah status jika ditugaskan
        ]);

        return redirect()->back()->with('success', 'Teknisi berhasil ditugaskan.');
    }

    // Fungsi untuk Update Status & Prioritas oleh Admin
    public function updateStatusAdmin(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status'    => 'required|string',
            'prioritas' => 'nullable|string',
        ]);

        $ticket->update([
            'status'    => $request->status,
            'prioritas' => $request->prioritas,
        ]);

        return redirect()->back()->with('success', 'Data tiket berhasil diperbarui.');
    }


    // --- DASHBOARD ROLE-BASED ---
    public function indexrole()
    {
        $user = auth()->user();
        $uslognm = $user->USLOGNM ?? null;
        $userData = USERLOG_ID::where('USERLOGNM', $uslognm)->first();
        $userId = $userData->ID ?? null;

        // Gunakan role dari user yang sedang login
        // Jika admin, lihat semua
        if ($user->role == 'admin') {
            $tickets = Ticket::with('user')->latest()->get();
        }
        // Jika rolenya mengandung kata 'teknisi'
        elseif (str_contains(strtolower($user->role), 'teknisi')) {
            $tickets = Ticket::with('user')
                ->where(function ($q) use ($userId, $uslognm) {
                    $q->where('teknisi_id', $userId)
                        ->orWhere('teknisi', 'LIKE', '%' . trim($uslognm) . '%');
                })
                ->latest()
                ->get();
        }
        // Selain itu (User biasa)
        else {
            $tickets = Ticket::with('user')
                ->where('user_id', $userId)
                ->latest()
                ->get();
        }

        return view('dashboard', compact('tickets'));
    }

    /**
     * Menampilkan halaman edit status untuk User atau Teknisi.
     */
    public function editStatus(Ticket $ticket)
    {
        $user = auth()->user();
        $uslognm = $user->USLOGNM ?? null;

        // Mengambil data user berdasarkan USERLOGNM dari tabel USERLOG_ROLES
        // Sesuai dengan struktur Navicat yang Anda miliki sebelumnya
        $userData = \Illuminate\Support\Facades\DB::table('USERLOG_ROLES')
            ->where('USERLOGNM', $uslognm)
            ->first();

        $userId = $userData?->id; // Gunakan 'id' huruf kecil sesuai foto Navicat

        // Cek apakah dia pemilik tiket atau teknisi yang ditugaskan
        $isOwner = ($ticket->user_id == $userId);
        $isTeknisi = (trim($ticket->teknisi) == trim($uslognm) || $ticket->teknisi_id == $userId);

        if (!$isOwner && !$isTeknisi) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah status tiket ini.');
        }

        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Menyimpan perubahan status tiket.
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|string|in:Open,On Progress,Done,Cancel',
        ]);

        $ticket->update([
            'status' => $request->status,
        ]);

        // Jika user adalah teknisi, arahkan kembali ke dashboard teknisi
        if (str_contains(strtolower(auth()->user()->role), 'teknisi')) {
            return redirect()->route('dashboard.teknisi')->with('success', 'Status tiket berhasil diperbarui.');
        }

        return redirect()->route('tickets.index')->with('success', 'Status tiket berhasil diperbarui.');
    }
}
