@extends('layouts.dashboard')

@section('content')
<div class="py-10">
  <div class="max-w-xl mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-900">Edit Status</h1>
    <p class="text-sm text-gray-500 mb-6">Tiket: {{ $ticket->ticket_number ?? ('IT-'.$ticket->id) }}</p>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <form method="POST" action="{{ route('tickets.updateStatus', $ticket->id) }}">
        @csrf
        @method('PUT')

        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
          @foreach (['Open','On Progress','Done','Closed'] as $st)
            <option value="{{ $st }}" {{ $ticket->status == $st ? 'selected' : '' }}>
              {{ $st }}
            </option>
          @endforeach
        </select>

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