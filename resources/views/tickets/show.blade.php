@extends('layouts.app')

@section('title', 'Detail Laporan - Lapor IT')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div>
                        <h1 class="text-2xl font-bold">Detail Laporan</h1>
                        <p class="text-blue-50">Lapor IT - Informasi Lengkap Tiket Problem Solving IT</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Detail --}}
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
            <div class="space-y-5 text-sm">

                <div class="pb-4 border-b border-blue-100">
                    <div class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                        Nomor Tiket
                    </div>
                    <div class="text-base font-bold text-blue-700">
                        {{ $ticket->nomor_tiket ?? '-' }}
                    </div>
                </div>

                <div class="pb-4 border-b border-blue-100">
                    <div class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                        Judul
                    </div>
                    <div class="text-base font-semibold text-gray-900">
                        {{ $ticket->judul }}
                    </div>
                </div>

                <div class="pb-4 border-b border-blue-100">
                    <div class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                        Deskripsi
                    </div>
                    <div class="text-base text-gray-700 leading-relaxed">
                        {{ $ticket->deskripsi }}
                    </div>
                </div>

                <div class="pb-4 border-b border-blue-100">
                    <div class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                        Lokasi
                    </div>
                    <div class="text-base text-gray-700">
                        {{ $ticket->lokasi }}
                    </div>
                </div>

                <div class="pb-4 border-b border-blue-100">
                    <div class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                        Status
                    </div>
                    <div class="text-base">
                        @php
                            $status = strtolower($ticket->status ?? 'open');
                        @endphp
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold border-2
                            {{ $status === 'done' ? 'bg-green-100 text-green-700 border-green-300' : '' }}
                            {{ $status === 'on progress' || $status === 'in_progress' ? 'bg-yellow-100 text-yellow-700 border-yellow-300' : '' }}
                            {{ $status === 'open' ? 'bg-blue-100 text-blue-700 border-blue-300' : '' }}
                            {{ $status === 'cancel' || $status === 'closed' ? 'bg-gray-100 text-gray-700 border-gray-300' : '' }}
                        ">
                            {{ $ticket->status ?? 'Open' }}
                        </span>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-1 text-xs font-bold text-blue-900 mb-2">
                        Tanggal Dibuat
                    </div>
                    <div class="text-base text-gray-700">
                        {{ $ticket->created_at->format('l, d F Y H:i') }}
                    </div>
                </div>

            </div>
        </div>

        {{-- Action --}}
        <div class="flex justify-end">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-1 px-6 py-2.5 rounded-xl bg-gradient-to-r from-slate-600 to-slate-800 text-white text-sm font-bold hover:scale-105 transition-transform shadow-md">
                Kembali
            </a>
        </div>

    </div>
@endsection
