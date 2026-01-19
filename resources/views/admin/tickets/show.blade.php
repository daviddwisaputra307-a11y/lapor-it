{{-- resources/views/admin/tickets/show.blade.php --}}
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

    <div class="max-w-6xl mx-auto space-y-4">

        {{-- Header --}}
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <h1 class="text-xl font-extrabold">Detail Ticket (Admin)</h1>
                <p class="text-sm text-slate-500"></p>
            </div>

            <a href="{{ route('admin.tickets.index') }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-blue-600 text-blue-700 bg-white hover:bg-blue-600 hover:text-white transition text-sm font-semibold">
                ← Kembali
            </a>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-800
                    px-4 py-2 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Badges --}}
        <div class="flex flex-wrap gap-2">
            <span
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                No: {{ $ticket->nomor_tiket ?? '-' }}
            </span>

            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusChip }}">
                Status: {{ $st }}
            </span>

            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $prioChip }}">
                Prioritas: {{ $pr }}
            </span>

            <span
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-700 border border-sky-200">
                Teknisi: {{ $ticket->teknisi ?? '-' }}
            </span>
        </div>

        {{-- Content --}}
        <div class="flex flex-wrap gap-4">

            {{-- Kiri --}}
            <div
                class="flex-1 min-w-[320px] bg-white border border-slate-200 rounded-2xl
                    p-5 shadow-[0_8px_20px_rgba(15,23,42,0.06)]">
                <div class="font-extrabold mb-3">Informasi Ticket</div>

                <label class="block text-xs text-slate-600 mb-1">Tanggal</label>
                <input readonly class="w-full px-3 py-2 mb-3 rounded-xl border border-slate-300 bg-white text-sm"
                    value="{{ $ticket->created_at?->format('Y-m-d H:i:s') ?? '-' }}">

                <label class="block text-xs text-slate-600 mb-1">Lokasi</label>
                <input readonly class="w-full px-3 py-2 mb-3 rounded-xl border border-slate-300 bg-white text-sm"
                    value="{{ $ticket->lokasi ?? '-' }}">

                <label class="block text-xs text-slate-600 mb-1">Judul</label>
                <input readonly class="w-full px-3 py-2 mb-3 rounded-xl border border-slate-300 bg-white text-sm"
                    value="{{ $ticket->judul ?? '-' }}">

                <label class="block text-xs text-slate-600 mb-1">Deskripsi</label>
                <textarea readonly class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-sm min-h-[90px]">{{ $ticket->deskripsi ?? '-' }}</textarea>
            </div>

            {{-- Kanan --}}
            <div class="flex-1 min-w-[320px] flex flex-col gap-4">

                {{-- Assign Teknisi --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-[0_8px_20px_rgba(15,23,42,0.06)]">
                    <div class="font-extrabold mb-3">Assign Teknisi</div>

                    <form method="POST" action="{{ route('admin.tickets.assign', $ticket->id) }}" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Pilih teknisi</label>
                            <select name="teknisi" required
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-sm">
                                <option value="">-- pilih --</option>
                                @foreach ($teknisiList ?? [] as $t)
                                    <option value="{{ $t }}" @selected($ticket->teknisi === $t)>
                                        {{ $t }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full px-4 py-2 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition">
                            Simpan Teknisi
                        </button>
                    </form>
                </div>

                {{-- Update Status --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-[0_8px_20px_rgba(15,23,42,0.06)]">
                    <div class="font-extrabold mb-3">Update Status / Prioritas</div>

                    <form method="POST" action="{{ route('admin.tickets.status', $ticket->id) }}" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Status</label>
                            <select name="status" required
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-sm">
                                @foreach (['Open', 'On Progress', 'Done', 'Cancel'] as $s)
                                    <option value="{{ $s }}" @selected($ticket->status === $s)>
                                        {{ $s }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Prioritas</label>
                            <select name="prioritas"
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-sm">
                                <option value="">-- pilih --</option>
                                @foreach (['Low', 'Medium', 'High', 'Urgent'] as $p)
                                    <option value="{{ $p }}" @selected($ticket->prioritas === $p)>
                                        {{ $p }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full px-4 py-2 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition">
                            Update
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
