@extends('layouts.app')

@section('title', 'Admin - Semua Tiket - Lapor IT')

@section('content')
    <div class="space-y-6">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white">
                <div class="flex items-center gap-3">
                    <div>
                        <h1 class="text-2xl font-bold">Admin - Semua Tiket</h1>
                        <p class="text-blue-50">Lapor IT - Kelola Tiket, Assign Teknisi, dan Pantau Status</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-blue-100 rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-900 text-sm font-bold">
                                <th class="px-4 py-4 text-left border-b border-blue-200">No Tiket</th>
                                <th class="px-4 py-4 text-left border-b border-blue-200">Judul</th>
                                <th class="px-4 py-4 text-left border-b border-blue-200">Lokasi</th>
                                <th class="px-4 py-4 text-left border-b border-blue-200">Prioritas</th>
                                <th class="px-4 py-4 text-left border-b border-blue-200">Status</th>
                                <th class="px-4 py-4 text-left border-b border-blue-200">Teknisi</th>
                                <th class="px-4 py-4 text-center border-b border-blue-200">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-blue-50">
                            @foreach ($tickets as $t)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-4 text-sm">
                                        <span class="font-bold text-blue-700">{{ $t->nomor_tiket }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $t->judul }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        <div class="flex items-center gap-1">
                                            {{ $t->lokasi }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-sm">
                                        @php
                                            $prioritas = $t->prioritas ?? '-';
                                            $warna = [
                                                'Low' => 'border-green-300 bg-green-50 text-green-700',
                                                'Medium' => 'border-yellow-300 bg-yellow-50 text-yellow-700',
                                                'High' => 'border-orange-300 bg-orange-50 text-orange-700',
                                                'Critical' => 'border-red-300 bg-red-50 text-red-700',
                                                'Urgent' => 'border-red-300 bg-red-50 text-red-700',
                                            ][$prioritas] ?? 'border-gray-300 bg-gray-50 text-gray-700';
                                        @endphp
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold border-2 {{ $warna }}">
                                            {{ $prioritas }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-sm">
                                        @php
                                            $status = $t->status ?? '-';
                                            $warnaStatus = [
                                                'Open' => 'border-blue-300 bg-blue-50 text-blue-700',
                                                'On Progress' => 'border-yellow-300 bg-yellow-50 text-yellow-700',
                                                'Done' => 'border-green-300 bg-green-50 text-green-700',
                                                'closed' => 'border-gray-300 bg-gray-50 text-gray-700',
                                                'Reopen' => 'border-orange-300 bg-orange-50 text-orange-700',
                                            ][$status] ?? 'border-gray-300 bg-gray-50 text-gray-700';
                                        @endphp
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold border-2 {{ $warnaStatus }}">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        <div class="flex items-center gap-1">
                                            {{ $t->teknisi ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            {{-- Detail untuk melihat --}}
                                            <a href="{{ route('tickets.show', $t->id) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold rounded-xl bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white transition">
                                                Detail
                                            </a>
                                            {{-- Edit untuk Admin mengelola --}}
                                            <a href="{{ route('admin.tickets.edit', $t->id) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold rounded-xl bg-orange-100 text-orange-700 hover:bg-orange-600 hover:text-white transition">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($tickets->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-blue-100">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
