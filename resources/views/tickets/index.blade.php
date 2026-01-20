@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    @php
        $userLogName = trim(auth()->user()->USLOGNM);
        $rawRole = \App\Models\USERLOG_ROLES::whereRaw("LTRIM(RTRIM(USERLOGNM)) = ?", [$userLogName])->value('USERLOG_ROLES');
        $myRole = strtolower(trim($rawRole)); 
    @endphp

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Laporan IT</h1>
    </div>

    {{-- Card --}}
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-700 font-bold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">No Tiket</th>
                        <th class="px-6 py-3 text-left">Judul</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                        @php 
                            $status = strtolower($ticket->status ?? 'open'); 
                        @endphp

                        {{-- Baris Utama --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-gray-900">
                                {{ $ticket->nomor_tiket ?? ($ticket->ticket_number ?? ('IT-'.$ticket->id)) }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $ticket->judul ?? ($ticket->title ?? '-') }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold uppercase border
                                    {{ $status === 'done' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                    {{ $status === 'on progress' || $status === 'in_progress' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : '' }}
                                    {{ $status === 'open' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                    {{ $status === 'cancel' || $status === 'closed' ? 'bg-gray-50 text-gray-700 border-gray-200' : '' }}
                                ">
                                    {{ $status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                {{ optional($ticket->created_at)->format('d/m/Y H:i') ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    {{-- Tombol Detail Lipat --}}
                                    <button type="button" onclick="toggleDetail(this)"
                                        class="inline-flex items-center px-3 py-1.5 bg-slate-800 text-white rounded text-xs font-bold hover:bg-black transition-colors">
                                        Detail
                                    </button>

                                    {{-- Tombol Edit HANYA untuk Admin --}}
                                    @if($myRole === 'admin')
                                        <a href="{{ route('tickets.editStatus', $ticket->id) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded text-xs font-bold hover:bg-red-700 transition-colors">
                                           Edit
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Baris Detail Lipat --}}
                        <tr class="hidden detail-row bg-gray-50">
                            <td colspan="5" class="px-6 py-4">
                                <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm text-sm text-gray-800 space-y-2">
                                    <p><b>Deskripsi:</b> {{ $ticket->deskripsi ?? ($ticket->description ?? '-') }}</p>
                                    <p><b>Lokasi:</b> {{ $ticket->lokasi ?? ($ticket->location ?? '-') }}</p>
                                    <p><b>Dibuat Pada:</b> {{ optional($ticket->created_at)->format('l, d F Y H:i') }}</p>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                                Belum ada laporan yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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