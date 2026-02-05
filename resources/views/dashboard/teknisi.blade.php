@extends('layouts.app')

@section('title', 'Dashboard Teknisi - Lapor IT')

@section('content')
    {{-- BAGIAN HEADER --}}
    <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-2xl font-bold">Dashboard Teknisi</h1>
                    <p class="text-blue-50">Lapor IT - Platform Tiketing Problem Solving IT Rumah Sakit</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('tickets.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-xl font-semibold text-sm hover:bg-blue-50 transition-colors shadow-md">
                    Buat Laporan
                </a>
                <a href="{{ route('tickets.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur text-white rounded-xl font-semibold text-sm hover:bg-white/30 transition-colors">
                    Semua Tiket
                </a>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        {{-- KOTAK STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="bg-white border border-blue-200 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Assigned</span>
                </div>
                <div class="text-4xl font-extrabold text-slate-900">{{ $total ?? 0 }}</div>
                <div class="text-sm text-slate-500 mt-1">Total Tugas</div>
            </div>
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-300 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-yellow-700 bg-yellow-200 px-2 py-1 rounded-full">Open</span>
                </div>
                <div class="text-4xl font-extrabold text-yellow-600">{{ $open ?? 0 }}</div>
                <div class="text-sm text-yellow-600 mt-1">Menunggu</div>
            </div>
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-300 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-orange-700 bg-orange-200 px-2 py-1 rounded-full">Progress</span>
                </div>
                <div class="text-4xl font-extrabold text-orange-600">{{ $prog ?? 0 }}</div>
                <div class="text-sm text-orange-600 mt-1">Sedang Dikerjakan</div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-300 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-green-700 bg-green-200 px-2 py-1 rounded-full">Done</span>
                </div>
                <div class="text-4xl font-extrabold text-green-600">{{ $done ?? 0 }}</div>
                <div class="text-sm text-green-600 mt-1">Selesai</div>
            </div>
        </div>

        {{-- TABEL DAFTAR TIKET --}}
        <div class="bg-white shadow-lg rounded-2xl border border-blue-100 overflow-hidden">
            <div class="p-5 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-blue-100">
                <div class="flex items-center gap-2">
                    <div>
                        <div class="font-bold text-blue-900">Daftar Tiket (Tugas & Laporan Saya)</div>
                        <div class="text-xs text-blue-600">Menampilkan 10 aktivitas terakhir.</div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-900 font-bold">
                        <tr>
                            <th class="px-4 py-3 text-left">No Tiket</th>
                            <th class="px-4 py-3 text-left">Judul</th>
                            <th class="px-4 py-3 text-left">Peran</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-50">
                        @forelse($tickets ?? [] as $t)
                            @php $status = $t->status ?? 'Open'; @endphp
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-4 py-3">
                                    <span class="font-bold text-blue-700">{{ $t->nomor_tiket ?? ('IT-'.$t->id) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-900">{{ $t->judul ?? '-' }}</div>
                                    <div class="text-xs text-gray-500 flex items-center gap-1">
                                        {{ $t->lokasi ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if(trim($t->teknisi) == trim(auth()->user()->USLOGNM))
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">
                                            PENANGANAN
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                                            PELAPOR
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold
                                        @if($status === 'Done') bg-green-100 text-green-700
                                        @elseif($status === 'On Progress') bg-yellow-100 text-yellow-700
                                        @else bg-blue-100 text-blue-700 @endif">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div class="flex items-center gap-1">
                                        {{ optional($t->created_at)->format('d/m/Y H:i') ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    @if(trim($t->teknisi) == trim(auth()->user()->USLOGNM))
                                        <a href="{{ route('tickets.editStatus', $t->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-bold hover:underline">
                                            Update
                                        </a>
                                    @else
                                        <a href="{{ route('tickets.show', $t->id) }}" class="inline-flex items-center gap-1 text-gray-600 hover:text-gray-800 font-bold hover:underline">
                                            Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="italic">Belum ada data tiket tugas untuk Anda.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
