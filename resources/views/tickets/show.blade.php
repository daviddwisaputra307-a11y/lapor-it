@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-lg p-6">

        {{-- Title --}}
        <h2 class="text-lg font-bold mb-6 flex items-center gap-2">
            🧾 Detail Laporan
        </h2>

        {{-- Item --}}
        <div class="space-y-4 text-sm">

            <div>
                <div class="text-slate-500">Nomor Tiket</div>
                <div class="text-base font-medium">
                    {{ $ticket->nomor_tiket ?? '-' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Judul</div>
                <div class="text-base font-medium">
                    {{ $ticket->judul }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Deskripsi</div>
                <div class="text-base font-medium leading-relaxed">
                    {{ $ticket->deskripsi }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Lokasi</div>
                <div class="text-base font-medium">
                    {{ $ticket->lokasi }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Status</div>
                <div class="text-base font-medium">
                    {{ $ticket->status ?? 'Open' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Tanggal</div>
                <div class="text-base font-medium">
                    {{ $ticket->created_at }}
                </div>
            </div>

        </div>

        {{-- Action --}}
        <div class="mt-6">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2
                      px-4 py-2 rounded-lg border border-blue-600
                      bg-blue-100 text-blue-600 text-sm font-semibold
                      hover:bg-blue-600 hover:text-white transition">
                ← Kembali
            </a>
        </div>

    </div>
@endsection
