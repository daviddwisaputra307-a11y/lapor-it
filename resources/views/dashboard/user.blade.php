@extends('layouts.app')

@section('title', 'Dashboard User - Lapor IT')

@section('content')
    {{-- BAGIAN HEADER --}}
    <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-2xl font-bold">Dashboard User</h1>
                    <p class="text-blue-50">Lapor IT - Platform Tiketing Problem Solving IT Rumah Sakit</p>
                </div>
            </div>
            <a href="{{ route('tickets.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-white text-blue-600 rounded-xl font-semibold text-sm hover:bg-blue-50 transition-colors shadow-md">
                Buat Laporan
            </a>
        </div>
    </div>

    <div class="space-y-6">
        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="bg-white border border-blue-200 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Total</span>
                </div>
                <div class="text-4xl font-extrabold text-slate-900">{{ $total ?? 0 }}</div>
                <div class="text-sm text-slate-500 mt-1">Total Laporan</div>
            </div>
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-300 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-yellow-700 bg-yellow-200 px-2 py-1 rounded-full">Open</span>
                </div>
                <div class="text-4xl font-extrabold text-yellow-600">{{ $open ?? 0 }}</div>
                <div class="text-sm text-yellow-600 mt-1">Menunggu</div>
            </div>
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-300 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-orange-700 bg-orange-200 px-2 py-1 rounded-full">Progress</span>
                </div>
                <div class="text-4xl font-extrabold text-orange-600">{{ $prog ?? 0 }}</div>
                <div class="text-sm text-orange-600 mt-1">Sedang Dikerjakan</div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-300 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-green-700 bg-green-200 px-2 py-1 rounded-full">Done</span>
                </div>
                <div class="text-4xl font-extrabold text-green-600">{{ $done ?? 0 }}</div>
                <div class="text-sm text-green-600 mt-1">Selesai</div>
            </div>
        </div>
    </div>
@endsection
