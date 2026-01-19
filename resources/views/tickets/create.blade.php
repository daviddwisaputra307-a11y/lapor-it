@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Buat Laporan IT</h1>
        <a href="{{ route('tickets.index') }}" class="text-sm text-blue-600 hover:underline">
        </a>
    </div>

    {{-- Alert success --}}
    @if (session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- Error summary --}}
    @if ($errors->any())
        <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
            <strong>Gagal:</strong> cek input kamu ya.
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('tickets.store') }}">
            @csrf

            {{-- Judul --}}
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                <input
                    id="judul"
                    type="text"
                    name="judul"
                    value="{{ old('judul') }}"
                    placeholder="Contoh: Printer error / WiFi lemot / PC bluescreen"
                    class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    required
                >
                @error('judul')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="5"
                    placeholder="Jelasin singkat: masalahnya apa, kapan kejadian, ada pesan error apa..."
                    class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    required
                >{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Lokasi --}}
                <div>
                    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi / Unit Kerja</label>
                    <select id="lokasi" name="lokasi"
  
                    class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                  </option>
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
                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Prioritas --}}
                <div>
                    <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                    <select
                        id="prioritas"
                        name="prioritas"
                        class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option value="Low" {{ old('prioritas', 'Low') == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('prioritas') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('prioritas') == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('prioritas')
                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ url()->previous() }}"
       class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
        Batal
    </a>
<button type="submit" style="padding:10px 18px; background:#2563eb; color:#fff; border-radius:8px; border:none; font-weight:600;">
  Kirim
</button>
  </div>
            </div>
        </form>
    </div>
</div>
@endsection