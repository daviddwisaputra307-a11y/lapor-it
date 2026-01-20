@extends('layouts.app')

@section('content')
    {{-- BAGIAN HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard User
        </h2>
        <a href="{{ route('tickets.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
            + Buat Laporan
        </a>
    </div>

    <div class="space-y-6">
        {{-- STATISTIK (Sesuai tampilan di image_500401.png) --}}
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="bg-white shadow-sm sm:rounded-lg p-4 border-b-2 border-blue-500">
                <div class="text-sm text-gray-500">Total</div>
                <div class="text-2xl font-bold">{{ $total ?? 0 }}</div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-4 border-b-2 border-yellow-500">
                <div class="text-sm text-gray-500">Open</div>
                <div class="text-2xl font-bold">{{ $open ?? 0 }}</div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-4 border-b-2 border-orange-500">
                <div class="text-sm text-gray-500">On Progress</div>
                <div class="text-2xl font-bold">{{ $prog ?? 0 }}</div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-4 border-b-2 border-green-500">
                <div class="text-sm text-gray-500">Done</div>
                <div class="text-2xl font-bold">{{ $done ?? 0 }}</div>
            </div>
        </div>
    </div>
@endsection
