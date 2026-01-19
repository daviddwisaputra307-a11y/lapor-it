<x-app-layout>
<x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Pelaporan IT') }}
            </h2>
            <a href="{{ route('tickets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                + Buat Laporan Baru
            </a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-4 text-gray-600 dark:text-gray-400 px-2">
                Login sebagai: <span class="font-bold text-blue-600 uppercase">{{ Auth::user()->USERLOG_ROLES }}</span>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if($tickets->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500 text-lg mb-4">Belum ada data tiket.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelapor</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Masalah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        @if(Auth::user()->USERLOG_ROLES == 'admin' || Auth::user()->USERLOG_ROLES == 'teknisi')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi (Teknisi)</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($tickets as $ticket)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm font-bold">{{ $ticket->user->name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium">{{ $ticket->judul }}</div>
                                            <div class="text-xs text-gray-500">{{ Str::limit($ticket->deskripsi, 40) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $ticket->status == 'open' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $ticket->status == 'closed' ? 'bg-gray-100 text-gray-800' : '' }}
                                                {{ $ticket->status == 'in_progress' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </td>

                                        @if(Auth::user()->USERLOG_ROLES == 'admin' || Auth::user()->USERLOG_ROLES == 'teknisi')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 px-3 py-1 rounded-md">
                                                    Update Status
                                                </a>
                                            </td>
                                        @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>