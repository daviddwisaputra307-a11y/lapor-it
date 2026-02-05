@extends('layouts.app')

@section('title', 'Edit Ticket (Admin) - Lapor IT')

@section('content')
    @php
        $st = $ticket->status ?? '-';
        $statusChip = match ($st) {
            'Open' => 'bg-blue-100 text-blue-700 border-blue-300',
            'On Progress' => 'bg-amber-100 text-amber-700 border-amber-300',
            'Done' => 'bg-green-100 text-green-700 border-green-300',
            'Cancel' => 'bg-red-100 text-red-700 border-red-300',
            default => 'bg-slate-100 text-slate-700 border-slate-300',
        };

        $statusIcon = match ($st) {
            'Open' => 'pending',
            'On Progress' => 'autorenew',
            'Done' => 'check_circle',
            'Cancel' => 'cancel',
            default => 'help',
        };

        $pr = $ticket->prioritas ?? '-';
        $prioChip = match ($pr) {
            'Low' => 'bg-slate-100 text-slate-700 border-slate-300',
            'Medium' => 'bg-sky-100 text-sky-700 border-sky-300',
            'High' => 'bg-amber-100 text-amber-700 border-amber-300',
            'Urgent' => 'bg-red-100 text-red-700 border-red-300',
            default => 'bg-slate-100 text-slate-700 border-slate-300',
        };
    @endphp

    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div>
                        <h1 class="text-2xl font-bold">Edit Ticket (Admin)</h1>
                        <p class="text-blue-50">Lapor IT - Kelola Detail Laporan dan Penugasan Teknisi</p>
                    </div>
                </div>

                <a href="{{ route('admin.tickets.index') }}"
                    class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-white text-blue-600 hover:bg-blue-50 transition text-sm font-semibold shadow-md">
                    Kembali
                </a>
            </div>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="bg-emerald-50 border-2 border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="bg-red-50 border-2 border-red-300 text-red-800 px-4 py-3 rounded-xl text-sm shadow-sm">
                <div class="flex items-start gap-2">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Badges --}}
        <div class="flex flex-wrap gap-2">
            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border-2 border-blue-300">
                {{ $ticket->nomor_tiket ?? '-' }}
            </span>

            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold border-2 {{ $statusChip }}">
                {{ $st }}
            </span>

            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold border-2 {{ $prioChip }}">
                {{ $pr }}
            </span>

            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold bg-sky-100 text-sky-700 border-2 border-sky-300">
                {{ $ticket->teknisi ?? '-' }}
            </span>
        </div>

        {{-- Content Layout --}}
        <div class="flex flex-wrap gap-4">

            {{-- Kiri: Informasi Tiket --}}
            <div class="flex-1 min-w-[320px] bg-white border border-blue-100 rounded-2xl p-6 shadow-lg">
                <div class="flex items-center gap-2 font-bold text-blue-900 mb-4 border-b border-blue-200 pb-3">
                    Informasi Ticket
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                            Tanggal Laporan
                        </label>
                        <input readonly class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 bg-blue-50 text-sm"
                            value="{{ $ticket->created_at?->format('Y-m-d H:i:s') ?? '-' }}">
                    </div>

                    <div>
                        <label class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                            Lokasi / Bagian
                        </label>
                        <input readonly class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 bg-blue-50 text-sm"
                            value="{{ $ticket->lokasi ?? '-' }}">
                    </div>

                    <div>
                        <label class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                            Judul Masalah
                        </label>
                        <input readonly class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 bg-blue-50 text-sm font-semibold"
                            value="{{ $ticket->judul ?? '-' }}">
                    </div>

                    <div>
                        <label class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                            Deskripsi Kerusakan
                        </label>
                        <textarea readonly class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 bg-blue-50 text-sm min-h-[120px]">{{ $ticket->deskripsi ?? '-' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kanan: Form Aksi Admin --}}
            <div class="flex-1 min-w-[320px] flex flex-col gap-4">

                {{-- Card: Assign Teknisi --}}
                <div class="bg-white border border-blue-100 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-2 font-bold text-blue-900 mb-4 border-b border-blue-200 pb-3">
                        Assign Teknisi
                    </div>

                    <form method="POST" action="{{ route('admin.tickets.assign', $ticket->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                                Pilih Nama Teknisi
                            </label>
                            <select name="teknisi" required
                                class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 bg-white text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none">
                                <option value="">-- pilih teknisi --</option>
                                @foreach ($teknisiList ?? [] as $t)
                                    @php
                                        $val = is_object($t) ? $t->USERLOGNM : $t;
                                    @endphp
                                    <option value="{{ $val }}" @selected($ticket->teknisi === $val)>
                                        {{ $val }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold text-sm hover:scale-105 transition-transform shadow-md">
                            Simpan Penugasan
                        </button>
                    </form>
                </div>

                {{-- Card: Update Status / Prioritas --}}
                <div class="bg-white border border-blue-100 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-2 font-bold text-blue-900 mb-4 border-b border-blue-200 pb-3">
                        Update Status & Prioritas
                    </div>

                    <form method="POST" action="{{ route('admin.tickets.status', $ticket->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                                Status Progres
                            </label>
                            <select name="status" required
                                class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 bg-white text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none">
                                @foreach (['Open', 'On Progress', 'Done', 'Cancel'] as $s)
                                    <option value="{{ $s }}" @selected($ticket->status === $s)>
                                        {{ $s }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                                Tingkat Prioritas
                            </label>
                            <select name="prioritas"
                                class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 bg-white text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none">
                                <option value="">-- pilih prioritas --</option>
                                @foreach (['Low', 'Medium', 'High', 'Urgent'] as $p)
                                    <option value="{{ $p }}" @selected($ticket->prioritas === $p)>
                                        {{ $p }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-slate-600 to-slate-800 text-white font-bold text-sm hover:scale-105 transition-transform shadow-md">
                            Update Tiket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
