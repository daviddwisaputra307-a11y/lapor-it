@extends('layouts.dashboard')

@section('content')
<div class="py-10">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Daftar Laporan IT</h1>
      </div>
    </div>

    {{-- Card --}}
    <div class="bg-white shadow-sm rounded-xl border border-gray-200">
      <div class="overflow-x-auto">
        <table class="w-full table-fixed text-sm">
          <thead class="bg-gray-50 text-gray-700">
            <tr>
              <th class="w-40 text-left px-6 py-3 font-semibold">No Tiket</th>
              <th class="w-56 text-left px-6 py-3 font-semibold">Judul</th>
              <th class="w-28 text-left px-6 py-3 font-semibold">Lokasi</th>
              <th class="w-28 text-left px-6 py-3 font-semibold">Status</th>
              <th class="w-44 text-left px-6 py-3 font-semibold">Tanggal</th>
              <th class="w-40 min-w-[160px] text-left px-6 py-3 font-semibold">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200">
            @forelse($tickets as $ticket)
              @php $status = $ticket->status ?? 'open'; @endphp

              {{-- BARIS UTAMA --}}
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">
                  {{ $ticket->ticket_number ?? ('IT-'.$ticket->id) }}
                </td>

                <td class="px-6 py-4 text-gray-700">
                  {{ $ticket->judul ?? ($ticket->title ?? '-') }}
                </td>

                <td class="px-6 py-4 text-gray-700">
                  {{ $ticket->lokasi ?? ($ticket->location ?? '-') }}
                </td>

                <td class="px-6 py-4">
                  <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold
                    {{ $status === 'done' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $status === 'in_progress' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $status === 'open' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $status === 'closed' ? 'bg-gray-100 text-gray-700' : '' }}
                  ">
                    {{ ucfirst(str_replace('_',' ', $status)) }}
                  </span>
                </td>

                {{-- TANGGAL --}}
                <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                  {{ optional($ticket->created_at)->format('Y-m-d H:i') ?? '-' }}
                </td>

                {{-- AKSI --}}
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <button
                      type="button"
                      onclick="toggleDetail(this)"
                      class="inline-flex items-center justify-center px-3 py-1 rounded bg-gray-800 text-white text-sm hover:bg-gray-700">
                      Detail
                    </button>

                    <a href="{{ route('tickets.editStatus', $ticket->id) }}"
                      class="inline-flex items-center justify-center px-3 py-1 rounded bg-red-600 text-white text-sm hover:bg-red-700">
                      Edit
                    </a>
                  </div>
                </td>
              </tr>

              {{-- BARIS DETAIL (MUNCUL DI BAWAH, BUKAN PINDAH HALAMAN) --}}
              <tr class="hidden detail-row bg-gray-50">
                <td colspan="6" class="px-6 py-4">
                  <div class="p-4 bg-white rounded border border-gray-200 text-sm text-gray-800 space-y-1">
                    <p><b>No Tiket:</b> {{ $ticket->ticket_number ?? ('IT-'.$ticket->id) }}</p>
                    <p><b>Judul:</b> {{ $ticket->judul ?? ($ticket->title ?? '-') }}</p>
                    <p><b>Deskripsi:</b> {{ $ticket->deskripsi ?? ($ticket->description ?? '-') }}</p>
                    <p><b>Lokasi:</b> {{ $ticket->lokasi ?? ($ticket->location ?? '-') }}</p>
                    <p><b>Status:</b> {{ ucfirst(str_replace('_',' ', $status)) }}</p>
                    <p><b>Tanggal:</b> {{ optional($ticket->created_at)->format('Y-m-d H:i') ?? '-' }}</p>
                  </div>
                </td>
              </tr>

            @empty
              <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                  Belum ada laporan.
                </td>
              </tr>
            @endforelse
          </tbody>

        </table>
      </div>
    </div>

  </div>
</div>

<script>
  function toggleDetail(btn) {
    const tr = btn.closest('tr');
    const detailTr = tr.nextElementSibling;
    if (detailTr && detailTr.classList.contains('detail-row')) {
      detailTr.classList.toggle('hidden');
    }
  }
</script>
@endsection