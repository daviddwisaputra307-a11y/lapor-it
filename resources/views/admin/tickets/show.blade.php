@extends('layouts.app')

@section('title', 'Detail Ticket (Admin)')

@section('content')
    @php
        $st = $ticket->status ?? '-';
        $statusChip = match ($st) {
            'Open' => 'bg-blue-100 text-blue-700 border-blue-200',
            'On Progress' => 'bg-amber-100 text-amber-700 border-amber-200',
            'Done' => 'bg-green-100 text-green-700 border-green-200',
            'Cancel' => 'bg-red-100 text-red-700 border-red-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };

        $pr = $ticket->prioritas ?? '-';
        $prioChip = match ($pr) {
            'Low' => 'bg-slate-100 text-slate-700 border-slate-200',
            'Medium' => 'bg-sky-100 text-sky-700 border-sky-200',
            'High' => 'bg-amber-100 text-amber-700 border-amber-200',
            'Urgent' => 'bg-red-100 text-red-700 border-red-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    @endphp

    <div class="max-w-6xl mx-auto space-y-4 p-4">

        {{-- Header --}}
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <h1 class="text-xl font-extrabold text-slate-800">Detail Ticket (Admin)</h1>
                <p class="text-sm text-slate-500">Kelola detail laporan dan penugasan teknisi.</p>
            </div>

            <a href="{{ route('admin.tickets.index') }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-blue-600 text-blue-700 bg-white hover:bg-blue-600 hover:text-white transition text-sm font-semibold">
                ← Kembali
            </a>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-2 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-2 rounded-xl text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Badges --}}
        <div class="flex flex-wrap gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                No: {{ $ticket->nomor_tiket ?? '-' }}
            </span>

            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusChip }}">
                Status: {{ $st }}
            </span>

            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $prioChip }}">
                Prioritas: {{ $pr }}
            </span>

            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-700 border border-sky-200">
                Teknisi: {{ $ticket->teknisi ?? '-' }}
            </span>
        </div>

        {{-- Content Layout --}}
        <div class="flex flex-wrap gap-4">

            {{-- Kiri: Informasi Tiket --}}
            <div class="flex-1 min-w-[320px] bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <div class="font-extrabold text-slate-800 mb-4 border-b pb-2">Informasi Ticket</div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Tanggal Laporan</label>
                        <input readonly class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-sm"
                            value="{{ $ticket->created_at?->format('Y-m-d H:i:s') ?? '-' }}">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Lokasi / Bagian</label>
                        <input readonly class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-sm"
                            value="{{ $ticket->lokasi ?? '-' }}">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Judul Masalah</label>
                        <input readonly class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-sm font-semibold"
                            value="{{ $ticket->judul ?? '-' }}">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Deskripsi Kerusakan</label>
                        <textarea readonly class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-sm min-h-[120px]">{{ $ticket->deskripsi ?? '-' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kanan: Form Aksi Admin --}}
            <div class="flex-1 min-w-[320px] flex flex-col gap-4">

                {{-- Card: Assign Teknisi --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="font-extrabold text-slate-800 mb-4 border-b pb-2">Assign Teknisi</div>

                    <form method="POST" action="{{ route('admin.tickets.assign', $ticket->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Pilih Nama Teknisi</label>
                            <select name="teknisi" required
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">-- pilih teknisi --</option>
                                @foreach ($teknisiList ?? [] as $t)
                                    @php 
                                        // Menangani jika teknisiList berisi objek atau string
                                        $val = is_object($t) ? $t->USERLOGNM : $t;
                                    @endphp
                                    <option value="{{ $val }}" @selected($ticket->teknisi === $val)>
                                        {{ $val }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full px-4 py-2 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition shadow-md">
                            Simpan Penugasan
                        </button>
                    </form>
                </div>

                {{-- Card: Update Status / Prioritas --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="font-extrabold text-slate-800 mb-4 border-b pb-2">Update Status & Prioritas</div>

                    <form method="POST" action="{{ route('admin.tickets.status', $ticket->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Status Progres</label>
                            <select name="status" required
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                @foreach (['Open', 'On Progress', 'Done', 'Cancel'] as $s)
                                    <option value="{{ $s }}" @selected($ticket->status === $s)>
                                        {{ $s }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Tingkat Prioritas</label>
                            <select name="prioritas"
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">-- pilih prioritas --</option>
                                @foreach (['Low', 'Medium', 'High', 'Urgent'] as $p)
                                    <option value="{{ $p }}" @selected($ticket->prioritas === $p)>
                                        {{ $p }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full px-4 py-2 rounded-xl bg-slate-800 text-white font-bold text-sm hover:bg-black transition shadow-md">
                            Update Tiket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection