@extends('layouts.app')

@section('title', 'Admin - Semua Tiket')

@section('content')
    <div class="p-6">
        <div class="max-w-7xl mx-auto space-y-4">

            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        🛠️ Admin - Semua Tiket
                    </h2>
                    <p class="text-sm text-slate-500">
                        Kelola seluruh tiket penanganan IT, assign teknisi, dan pantau status.
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('dashboard.admin') }}"
                        class="px-4 py-2 text-sm font-bold rounded-lg border border-slate-300 text-slate-700 bg-white hover:bg-slate-800 hover:text-white transition">
                        ← Dashboard Admin
                    </a>

                    <a href="{{ route('tickets.index') }}"
                        class="px-4 py-2 text-sm font-bold rounded-lg border border-blue-600 text-blue-700 bg-white hover:bg-blue-600 hover:text-white transition">
                        Ke User List
                    </a>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 uppercase text-xs font-bold">
                                <th class="px-4 py-4 text-left border-b">No Tiket</th>
                                <th class="px-4 py-4 text-left border-b">Judul</th>
                                <th class="px-4 py-4 text-left border-b">Lokasi</th>
                                <th class="px-4 py-4 text-left border-b">Prioritas</th>
                                <th class="px-4 py-4 text-left border-b">Status</th>
                                <th class="px-4 py-4 text-left border-b">Teknisi</th>
                                <th class="px-4 py-4 text-center border-b">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach ($tickets as $t)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-4 text-sm font-mono font-bold">{{ $t->nomor_tiket }}</td>
                                    <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $t->judul }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-600">{{ $t->lokasi }}</td>

                                    <td class="px-4 py-4 text-sm">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold border border-slate-200 bg-gray-50">
                                            {{ $t->prioritas ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-sm">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold border 
                                            {{ $t->status == 'OPEN' ? 'border-green-200 bg-green-50 text-green-700' : 'border-slate-200 bg-slate-50 text-slate-700' }}">
                                            {{ $t->status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-sm text-gray-600">{{ $t->teknisi ?? '-' }}</td>

                                    <td class="px-4 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            {{-- Detail untuk melihat --}}
                                            <a href="{{ route('tickets.show', $t->id) }}"
                                                class="px-3 py-1.5 text-xs font-bold rounded-lg bg-slate-700 text-white hover:bg-black transition">
                                                Detail
                                            </a>
                                            {{-- Edit untuk Admin mengelola --}}
                                            <a href="{{ route('admin.tickets.show', $t->id) }}"
                                                class="px-3 py-1.5 text-xs font-bold rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($tickets->hasPages())
                    <div class="px-6 py-4 bg-slate-50 border-t">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection