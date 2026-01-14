<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard User
            </h2>
            <a href="{{ route('tickets.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                + Buat Laporan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <div class="text-sm text-gray-500">Total</div>
                    <div class="text-2xl font-bold">{{ $total ?? 0 }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <div class="text-sm text-gray-500">Open</div>
                    <div class="text-2xl font-bold">{{ $open ?? 0 }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <div class="text-sm text-gray-500">On Progress</div>
                    <div class="text-2xl font-bold">{{ $prog ?? 0 }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <div class="text-sm text-gray-500">Done</div>
                    <div class="text-2xl font-bold">{{ $done ?? 0 }}</div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-4 border-b">
                    <div class="font-semibold">Tiket Terbaru Saya</div>
                    <div class="text-sm text-gray-500">10 tiket terakhir.</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-700">
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
                                @php $status = $t->status ?? 'Open'; @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $t->ticket_number ?? $t->no_tiket ?? ('IT-'.$t->id) }}</td>
                                    <td class="px-4 py-3">{{ $t->title ?? $t->judul ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $t->location ?? $t->lokasi ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs
                                            @if($status === 'Done') bg-green-100 text-green-700
                                            @elseif($status === 'On Progress') bg-yellow-100 text-yellow-700
                                            @else bg-blue-100 text-blue-700
                                            @endif">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ optional($t->created_at)->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <a class="text-blue-600 hover:underline" href="{{ route('tickets.show', $t->id) }}">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada tiket.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
