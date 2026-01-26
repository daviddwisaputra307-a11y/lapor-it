@extends('layouts.app')

@section('title', 'Edit Status Tiket - Lapor IT')

@section('content')
<div class="space-y-6">
    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white">
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-2xl font-bold">Edit Status Tiket</h1>
                    <p class="text-blue-50">Lapor IT - Ubah Status Laporan Problem Solving IT</p>
                    <p class="text-sm text-white mt-1 flex items-center gap-1">
                        {{ $ticket->nomor_tiket ?? ('IT-'.$ticket->id) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- CARD --}}
        <div class="bg-white border border-blue-100 rounded-2xl shadow-lg p-6">
            <form method="POST" action="{{ route('tickets.updateStatus', $ticket->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                        Pilih Status Baru
                    </label>
                    <select
                        name="status"
                        class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 bg-white text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none"
                        required
                    >
                        {{-- Opsi Status --}}
                        <option value="Open" {{ ($ticket->status === 'Open') ? 'selected' : '' }}>
                            🔵 Reopen (Buka Kembali)
                        </option>
                        <option value="Done" {{ ($ticket->status === 'Done') ? 'selected' : '' }}>
                            ✅ Done (Selesai)
                        </option>
                        <option value="Cancel" {{ ($ticket->status === 'Cancel') ? 'selected' : '' }}>
                            ❌ Cancel (Batalkan)
                        </option>
                    </select>

                    @error('status')
                        <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    {{-- Tombol Batal --}}
                    <a href="{{ route('tickets.index') }}"
                       class="inline-flex items-center gap-1 px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-100 font-semibold transition">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center gap-1 px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold hover:scale-105 transition-transform shadow-md">
                            Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
