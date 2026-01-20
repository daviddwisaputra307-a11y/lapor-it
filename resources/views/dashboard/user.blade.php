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

        {{-- TABEL TIKET --}}
        <div class="bg-white shadow-sm sm:rounded-lg border">
            <div class="p-4 border-b bg-gray-50 font-semibold">
                Tiket Terbaru Saya
                <div class="text-xs text-gray-500 font-normal">10 tiket terakhir.</div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">No Tiket</th>
                            <th class="px-4 py-3 text-left">Judul</th>
                            <th class="px-4 py-3 text-left">Lokasi</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($tickets ?? [] as $t)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $t->nomor_tiket }}</td>
                                <td class="px-4 py-3 font-bold">{{ $t->judul }}</td>
                                <td class="px-4 py-3">{{ $t->lokasi }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold
                                        @if($t->status == 'Done') bg-green-100 text-green-700
                                        @elseif($t->status == 'On Progress') bg-yellow-100 text-yellow-700
                                        @else bg-blue-100 text-blue-700 @endif">
                                        {{ $t->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $t->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('tickets.show', $t->id) }}" class="text-blue-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500 italic">
                                    Belum ada tiket.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection