@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <div class="bg-white shadow sm:rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50 text-center">
            <h3 class="text-lg font-bold">Edit Status</h3>
            <p class="text-sm text-gray-500 font-mono">Tiket: {{ $ticket->nomor_tiket }}</p>
        </div>

        <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Baru</label>
                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach(['Open', 'On Progress', 'Done', 'Cancel'] as $st)
                        <option value="{{ $st }}" {{ $ticket->status == $st ? 'selected' : '' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('dashboard.teknisi') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection