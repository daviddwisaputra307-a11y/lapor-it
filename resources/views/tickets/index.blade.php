@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    @php
        $userLogName = trim(auth()->user()->USLOGNM);
        $rawRole = \App\Models\USERLOG_ROLES::whereRaw("LTRIM(RTRIM(USERLOGNM)) = ?", [$userLogName])->value('USERLOG_ROLES');
        $myRole = strtolower(trim($rawRole)); 
    @endphp

    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border">
        <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Daftar Laporan IT</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-600 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-6 py-3 text-left">No Tiket</th>
                        <th class="px-6 py-3 text-left">Judul</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono font-bold text-gray-900">{{ $ticket->nomor_tiket }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $ticket->judul }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase border
                                {{ $ticket->status == 'OPEN' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ $ticket->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $ticket->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                {{-- Tombol Detail dengan warna kontras tinggi --}}
                                <a href="{{ route('tickets.show', $ticket->id) }}" 
                                   class="inline-flex items-center px-4 py-1.5 bg-slate-800 text-white rounded text-xs font-bold hover:bg-black transition-colors">
                                   Detail
                                </a>

                                {{-- Edit HANYA untuk Admin --}}
                                @if($myRole === 'admin')
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" 
                                       class="inline-flex items-center px-4 py-1.5 bg-red-600 text-white rounded text-xs font-bold hover:bg-red-700 transition-colors">
                                       Edit
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">Belum ada laporan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection