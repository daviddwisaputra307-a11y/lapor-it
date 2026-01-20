@extends('layouts.dashboard')

@section('content')
<div class="py-10">
    <div class="max-w-xl mx-auto px-4">

        <h1 class="text-2xl font-bold text-gray-900">Edit Status</h1>
        <p class="text-sm text-gray-500 mt-1">
            Tiket: {{ $ticket->ticket_number ?? ('IT-'.$ticket->id) }}
        </p>

        {{-- CARD (penting: jangan pakai overflow-hidden biar dropdown gak kepotong) --}}
        <div class="bg-white relative z-10 rounded-xl shadow-sm border border-gray-200 p-6 mt-6">

            <form method="POST" action="{{ route('tickets.updateStatus', $ticket->id) }}">
                @csrf
                @method('PUT')

                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>

                <select
                    name="status"
                    class="w-full bg-white rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500"
                    required
                  >
                    {{-- Hanya 2 pilihan --}}
                    <option value="closed" {{ ($ticket->status === 'closed') ? 'selected' : '' }}>
                        Closed
                    </option>

                    <option value="open" {{ ($ticket->status !== 'closed') ? 'selected' : '' }}>
                        Reopen
                    </option>
                </select>

                {{-- error validation --}}
                @error('status')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('tickets.index') }}"
                       class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>

                    <button type="submit"
                            class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection