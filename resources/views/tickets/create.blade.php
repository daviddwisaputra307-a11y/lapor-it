@extends('layouts.app')

@section('title', 'Buat Laporan IT - Lapor IT')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white">
        <div class="flex items-center gap-3">
            <div>
                <h1 class="text-2xl font-bold">Buat Laporan IT</h1>
                <p class="text-blue-50">Lapor IT - Laporkan Problem IT di Rumah Sakit</p>
            </div>
        </div>
    </div>

    {{-- Alert success --}}
    @if (session('success'))
        <div class="rounded-xl border-2 border-green-300 bg-green-50 px-4 py-3 text-green-800 flex items-center gap-2 shadow-sm">
            <div><strong>Berhasil!</strong> {{ session('success') }}</div>
        </div>
    @endif

    {{-- Error summary --}}
    @if ($errors->any())
        <div class="rounded-xl border-2 border-red-300 bg-red-50 px-4 py-3 text-red-800 flex items-center gap-2 shadow-sm">
            <div><strong>Gagal:</strong> cek input kamu ya.</div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
        <form method="POST" action="{{ route('tickets.store') }}" class="space-y-5">
            @csrf

            {{-- Judul --}}
            <div>
                <label for="judul" class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                    Judul <span class="text-red-600">*</span>
                </label>
                <input
                    id="judul"
                    type="text"
                    name="judul"
                    value="{{ old('judul') }}"
                    placeholder="Contoh: Printer error / WiFi lemot / PC bluescreen"
                    class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                    required
                >
                @error('judul')
                    <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                    Deskripsi <span class="text-red-600">*</span>
                </label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="5"
                    placeholder="Jelasin singkat: masalahnya apa, kapan kejadian, ada pesan error apa..."
                    class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none resize-y"
                    required
                >{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Lokasi --}}
                <div>
                    <label for="lokasi" class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                        Lokasi / Unit Kerja <span class="text-red-600">*</span>
                    </label>
                    <select id="lokasi" name="lokasi"
                        class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none" required>
                        <option value="" disabled {{ old('lokasi') ? '' : 'selected' }}>
                            -- pilih lokasi --
                        </option>
                        @foreach ($bagians as $b)
                            <option value="{{ $b->KODEBAGIAN }}"
                                {{ old('lokasi') == $b->KODEBAGIAN ? 'selected' : '' }}>
                                {{ $b->NAMABAGIAN }}
                            </option>
                        @endforeach
                    </select>
                    @error('lokasi')
                        <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Prioritas --}}
                <div>
                    <label for="prioritas" class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                        Prioritas <span class="text-red-600">*</span>
                    </label>
                    <select
                        id="prioritas"
                        name="prioritas"
                        class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                        required
                    >
                        <option value="Low" {{ old('prioritas', 'Low') == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('prioritas') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('prioritas') == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('prioritas')
                        <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center gap-1 px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-100 font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-1 px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold hover:scale-105 transition-transform shadow-md">
                        Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
