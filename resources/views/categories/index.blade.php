@extends('layouts.app')

@section('title', 'Kategori - Lapor IT')

@section('content')
    <div class="max-w-full mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div>
                        <h1 class="text-2xl font-bold">Kelola Kategori</h1>
                        <p class="text-blue-50">Lapor IT - Manajemen Kategori Tiket Problem Solving IT</p>
                    </div>
                </div>
                <a href="{{ route('categories.create') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-white text-blue-600 rounded-xl font-semibold text-sm hover:bg-blue-50 transition-colors shadow-md">
                    Tambah Kategori
                </a>
            </div>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <div class="px-4 py-3 rounded-xl border bg-emerald-50 border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Card -->
        <div class="bg-white border border-blue-100 rounded-2xl shadow-lg overflow-hidden">
            @if ($categories->isEmpty())
                <div class="text-center py-16 text-gray-400">
                    <p class="text-sm italic">Belum ada kategori. Silakan tambah kategori baru.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-900">
                                <th class="px-4 py-3 text-left text-sm font-bold border-b border-blue-200">No</th>
                                <th class="px-4 py-3 text-left text-sm font-bold border-b border-blue-200">Nama Kategori</th>
                                <th class="px-4 py-3 text-left text-sm font-bold border-b border-blue-200">Deskripsi</th>
                                <th class="px-4 py-3 text-right text-sm font-bold border-b border-blue-200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-50">
                            @foreach ($categories as $cat)
                                <tr class="hover:bg-blue-50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-gray-900">{{ $cat->nama_kategori }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $cat->deskripsi ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex justify-end gap-2">
                                            <!-- Edit -->
                                            <a href="{{ route('categories.edit', $cat->id) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs rounded-xl bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white transition font-semibold">
                                                Edit
                                            </a>

                                            <!-- Delete -->
                                            <form method="POST" action="{{ route('categories.destroy', $cat->id) }}"
                                                onsubmit="return confirm('Yakin hapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="hidden inline-flex items-center gap-1 px-3 py-1.5 text-xs rounded-xl bg-red-100 text-red-700 hover:bg-red-600 hover:text-white transition font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-3 bg-gray-50 border-t border-blue-100">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
