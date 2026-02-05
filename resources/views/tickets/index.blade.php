@extends('layouts.app')

@section('title', 'Daftar Laporan - Lapor IT')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        @php
            $userLogName = trim(auth()->user()->USLOGNM);
            $rawRole = \App\Models\USERLOG_ROLES::whereRaw('LTRIM(RTRIM(USERLOGNM)) = ?', [$userLogName])->value(
                'USERLOG_ROLES',
            );
            $myRole = strtolower(trim($rawRole));
        @endphp

        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white">
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-2xl font-bold">Daftar Laporan IT</h1>
                    <p class="text-blue-50">Lapor IT - Semua Tiket Problem Solving IT Rumah Sakit</p>
                </div>
            </div>
        </div>

        {{-- Card --}}
        <div class="bg-white shadow-lg rounded-2xl border border-blue-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-900">
                        <tr>
                            <th class="px-6 py-3 text-left font-bold">No Tiket</th>
                            <th class="px-6 py-3 text-left font-bold">Judul</th>
                            <th class="px-6 py-3 text-left font-bold">Status</th>
                            <th class="px-6 py-3 text-left font-bold">Tanggal</th>
                            <th class="px-6 py-3 text-center font-bold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-blue-50">
                        @forelse($tickets as $ticket)
                            @php
                                $status = strtolower($ticket->status ?? 'open');
                            @endphp

                            {{-- Baris Utama --}}
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span
                                        class="font-bold text-blue-700">{{ $ticket->nomor_tiket ?? ($ticket->ticket_number ?? 'IT-' . $ticket->id) }}</span>
                                </td>

                                <td class="px-6 py-4 text-gray-900 font-medium">
                                    {{ $ticket->judul ?? ($ticket->title ?? '-') }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold border
                                    {{ $status === 'done' ? 'bg-green-100 text-green-700 border-green-300' : '' }}
                                    {{ $status === 'on progress' || $status === 'in_progress' ? 'bg-yellow-100 text-yellow-700 border-yellow-300' : '' }}
                                    {{ $status === 'open' ? 'bg-blue-100 text-blue-700 border-blue-300' : '' }}
                                    {{ $status === 'cancel' || $status === 'closed' ? 'bg-gray-100 text-gray-700 border-gray-300' : '' }}
                                ">
                                        {{ $status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                    <div class="flex items-center gap-1">
                                        {{ optional($ticket->created_at)->format('d/m/Y H:i') ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        {{-- Tombol Detail Lipat --}}
                                        <button type="button" onclick="toggleDetail(this)"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-slate-600 to-slate-800 text-white rounded-xl text-xs font-bold hover:scale-105 transition-transform shadow">
                                            Detail
                                        </button>

                                        {{-- Tombol Edit HANYA untuk Admin --}}
                                        @if ($myRole === 'admin')
                                            <a href="{{ route('tickets.editStatus', $ticket->id) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl text-xs font-bold hover:scale-105 transition-transform shadow">
                                                Edit
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- Baris Detail Lipat --}}
                            <tr class="hidden detail-row bg-gradient-to-r from-blue-50 to-cyan-50">
                                <td colspan="5" class="px-6 py-4">
                                    <div
                                        class="p-5 bg-white rounded-xl border border-blue-200 shadow-sm text-sm text-gray-800 space-y-3">
                                        <div class="flex items-start gap-2">
                                            <div class="flex-1">
                                                <strong class="text-blue-900">Deskripsi:</strong>
                                                <p class="text-gray-700 mt-1">
                                                    {{ $ticket->deskripsi ?? ($ticket->description ?? '-') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span><strong class="text-blue-900">Lokasi:</strong>
                                                {{ $ticket->lokasi ?? ($ticket->location ?? '-') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span><strong class="text-blue-900">Dibuat Pada:</strong>
                                                {{ optional($ticket->created_at)->format('l, d F Y H:i') }}</span>
                                        </div>

                                        {{-- GAMBAR LAMPIRAN --}}
                                        @if ($ticket->path_gambar)
                                            <div class="pt-3 border-t border-blue-100">
                                                <strong class="text-blue-900 block mb-2">📷 Lampiran Gambar:</strong>
                                                <div class="mt-2">
                                                    <img src="{{ $ticket->gambar_url }}"
                                                        alt="Lampiran {{ $ticket->nomor_tiket }}"
                                                        class="max-w-xs h-auto rounded-lg border-2 border-blue-200 shadow cursor-pointer hover:shadow-xl hover:scale-105 transition"
                                                        style="max-height: 100px; object-fit: contain;"
                                                        onclick="showImageModal(this.src)">
                                                    <p class="text-xs text-gray-500 mt-1">Klik gambar untuk melihat ukuran
                                                        penuh</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="italic">Belum ada laporan yang tersedia.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($tickets->hasPages())
                <div class="px-6 py-4 bg-white border-t border-blue-100">
                    {{ $tickets->onEachSide(1)->links('pagination::tailwind') }}
                </div>
            @endif

        </div>
    </div>

    {{-- Modal Preview Gambar --}}
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4"
        onclick="closeImageModal()">
        <div class="relative max-w-6xl max-h-full" onclick="event.stopPropagation()">
            <button onclick="closeImageModal()"
                class="absolute -top-10 right-0 text-white text-2xl font-bold hover:text-gray-300 transition">
                ✕ Tutup
            </button>
            <img id="modalImage" src="" alt="Preview" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl">
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

        function showImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeImageModal();
        });
    </script>
@endsection
