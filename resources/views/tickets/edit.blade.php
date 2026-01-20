@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-xl mx-auto px-4">

        <h1 class="text-2xl font-bold text-gray-900">Edit Status</h1>
        <p class="text-sm text-gray-500 mt-1">
            Tiket: {{ $ticket->nomor_tiket ?? ('IT-'.$ticket->id) }}
        </p>

        {{-- CARD --}}
        <div class="bg-white relative z-10 rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
            <form method="POST" action="{{ route('tickets.updateStatus', $ticket->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Baru</label>
                    <select
                        name="status"
                        class="w-full bg-white rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500 outline-none"
                        required
                    >
                        {{-- Opsi Status --}}
                        <option value="Open" {{ ($ticket->status === 'Open') ? 'selected' : '' }}>Reopen (Buka Kembali)</option>
                        <option value="Done" {{ ($ticket->status === 'Done') ? 'selected' : '' }}>Done (Selesai)</option>
                        <option value="Cancel" {{ ($ticket->status === 'Cancel') ? 'selected' : '' }}>Cancel (Batalkan)</option>
                    </select>

                    @error('status')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    {{-- Tombol Batal diarahkan ke Dashboard sesuai keinginan Anda --}}
                    <a href="{{ route('dashboard') }}" 
                       class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold transition">
                        Batal
                    </a>

                    <button type="submit" 
                            class="px-4 py-2 rounded-lg bg-red-600 text-white font-bold hover:bg-red-700 transition shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection