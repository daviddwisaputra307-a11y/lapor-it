@extends('layouts.app')

@section('title', 'Admin - Semua Tiket')

@section('content')
    <div class=" bg-slate-100 p-6">
        <div class="max-w-5xl mx-auto space-y-4">

            <!-- Header -->
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-semibold">
                        🛠️ Admin - Semua Tiket
                    </h2>
                    <p class="text-sm text-slate-500">
                        Lihat semua tiket, cek detail, assign teknisi, ubah status.
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('dashboard.admin') }}"
                        class="px-3 py-1.5 text-sm rounded-xl border border-slate-300 text-slate-700 bg-white hover:bg-slate-800 hover:text-white transition">
                        ← Dashboard Admin
                    </a>

                    <a href="{{ route('tickets.index') }}"
                        class="px-3 py-1.5 text-sm rounded-xl border border-blue-600 text-blue-700 bg-white hover:bg-blue-600 hover:text-white transition">
                        Ke User List
                    </a>
                </div>
            </div>

            <!-- Card -->
            <div class="bg-white border border-slate-200 rounded-2xl p-4">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-3 py-3 text-left text-sm font-semibold border-b">No Tiket</th>
                                <th class="px-3 py-3 text-left text-sm font-semibold border-b">Judul</th>
                                <th class="px-3 py-3 text-left text-sm font-semibold border-b">Lokasi</th>
                                <th class="px-3 py-3 text-left text-sm font-semibold border-b">Prioritas</th>
                                <th class="px-3 py-3 text-left text-sm font-semibold border-b">Status</th>
                                <th class="px-3 py-3 text-left text-sm font-semibold border-b">Teknisi</th>
                                <th class="px-3 py-3 text-right text-sm font-semibold border-b">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($tickets as $t)
                                <tr class="border-b last:border-b-0 hover:bg-slate-50 transition">
                                    <td class="px-3 py-3 text-sm">{{ $t->nomor_tiket }}</td>
                                    <td class="px-3 py-3 text-sm font-medium">{{ $t->judul }}</td>
                                    <td class="px-3 py-3 text-sm">{{ $t->lokasi }}</td>

                                    <td class="px-3 py-3 text-sm">
                                        <span
                                            class="inline-flex px-3 py-0.5 text-xs rounded-full border border-slate-300 text-slate-700 bg-white">
                                            {{ $t->prioritas ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-3 py-3 text-sm">
                                        <span
                                            class="inline-flex px-3 py-0.5 text-xs rounded-full border border-slate-300 text-slate-700 bg-white">
                                            {{ $t->status }}
                                        </span>
                                    </td>

                                    <td class="px-3 py-3 text-sm">{{ $t->teknisi ?? '-' }}</td>

                                    <td class="px-3 py-3 text-right">
                                        <a href="{{ route('admin.tickets.show', $t->id) }}"
                                            class="inline-flex px-3 py-1.5 text-xs rounded-xl border border-blue-600 text-blue-700 bg-white hover:bg-blue-600 hover:text-white transition">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
