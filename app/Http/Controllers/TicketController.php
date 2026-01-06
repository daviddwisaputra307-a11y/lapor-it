<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
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

        return redirect()->back()->with('success', 'Laporan berhasil dikirim ✅');
    }
}
