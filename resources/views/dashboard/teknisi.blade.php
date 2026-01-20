@extends('layouts.app')

@section('content')
    {{-- BAGIAN HEADER: Judul & Tombol Aksi --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Teknisi
        </h2>
        <div class="flex space-x-2">
            <a href="{{ route('tickets.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                ➕ Buat Laporan
            </a>
            <a href="{{ route('tickets.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black">
                Lihat Semua Tiket
            </a>
        </div>
    </div>

    <div class="space-y-6">
        {{-- KOTAK STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="bg-white shadow-sm sm:rounded-lg p-4 border-b-2 border-blue-500">
                <div class="text-sm text-gray-500 font-semibold">Total Assigned</div>
                <div class="text-2xl font-bold">{{ $total ?? 0 }}</div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-4 border-b-2 border-yellow-500">
                <div class="text-sm text-gray-500 font-semibold">Open</div>
                <div class="text-2xl font-bold">{{ $open ?? 0 }}</div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-4 border-b-2 border-orange-500">
                <div class="text-sm text-gray-500 font-semibold">On Progress</div>
                <div class="text-2xl font-bold">{{ $prog ?? 0 }}</div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-4 border-b-2 border-green-500">
                <div class="text-sm text-gray-500 font-semibold">Done</div>
                <div class="text-2xl font-bold">{{ $done ?? 0 }}</div>
            </div>
        </div>

        {{-- TABEL DAFTAR TIKET --}}
        <div class="bg-white shadow-sm sm:rounded-lg border">
            <div class="p-4 border-b bg-gray-50">
                <div class="font-bold text-gray-700">Daftar Tiket (Tugas & Laporan Saya)</div>
                <div class="text-xs text-gray-500">Menampilkan 10 aktivitas terakhir.</div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100 text-gray-700 font-bold">
                        <tr>
                            <th class="px-4 py-3 text-left">No Tiket</th>
                            <th class="px-4 py-3 text-left">Judul</th>
                            <th class="px-4 py-3 text-left">Peran</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($tickets ?? [] as $t)
                            @php $status = $t->status ?? 'Open'; @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">{{ $t->nomor_tiket ?? ('IT-'.$t->id) }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-900">{{ $t->judul ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $t->lokasi ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @if(trim($t->teknisi) == trim(auth()->user()->USLOGNM))
                                        <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-[10px] font-bold">🛠️ PENANGANAN</span>
                                    @else
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">📝 PELAPOR</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold
                                        @if($status === 'Done') bg-green-100 text-green-700
                                        @elseif($status === 'On Progress') bg-yellow-100 text-yellow-700
                                        @else bg-blue-100 text-blue-700 @endif">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ optional($t->created_at)->format('d/m/Y H:i') ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    @if(trim($t->teknisi) == trim(auth()->user()->USLOGNM))
                                        <a href="{{ route('tickets.editStatus', $t->id) }}" class="text-blue-600 hover:underline font-bold">
                                            Update
                                        </a>
                                    @else
                                        <a href="{{ route('tickets.show', $t->id) }}" class="text-gray-600 hover:underline font-bold">
                                            Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500 italic">
                                    Belum ada data tiket tugas untuk Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection