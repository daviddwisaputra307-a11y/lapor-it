@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="max-w-full mx-auto">

        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <!-- Back Button -->
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm rounded-xl border border-slate-300 text-slate-600 bg-white hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition">
                    ← Kembali
                </a>

                <!-- Title -->
                <div>
                    <h2 class="text-lg font-semibold">📂 Kelola Kategori</h2>
                    <div class="text-sm text-slate-500">
                        Daftar kategori tiket yang tersedia
                    </div>
                </div>
            </div>

            <!-- Primary Button -->
            <a href="{{ route('categories.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl border border-green-600 text-green-700 bg-white hover:bg-green-600 hover:text-white transition">
                + Tambah Kategori
            </a>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <div
                class="mb-4 px-4 py-3 rounded-xl border
                        bg-emerald-50 border-emerald-200 text-emerald-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4">
            @if ($categories->isEmpty())
                <div class="text-center py-10 text-slate-400 text-sm">
                    Belum ada kategori. Silakan tambah kategori baru.
                </div>
            @else
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-3 py-3 text-left text-sm font-semibold border-b">No</th>
                            <th class="px-3 py-3 text-left text-sm font-semibold border-b">Nama Kategori</th>
                            <th class="px-3 py-3 text-center text-sm font-semibold border-b">Deskripsi</th>
                            <th class="px-3 py-3 text-right text-sm font-semibold border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $cat)
                            <tr class="border-b last:border-b-0 hover:bg-slate-100">
                                <td class="px-3 py-3 text-sm">
                                    {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                </td>
                                <td class="px-3 py-3 text-sm font-semibold">
                                    {{ $cat->nama_kategori }}
                                </td>
                                <td class="px-3 py-3 text-sm {{ $cat->deskripsi ? 'text-left' : 'text-center' }}">
                                    {{ $cat->deskripsi ?? '-' }}
                                </td>
                                <td class="px-3 py-3 text-right">
                                    <div class="flex justify-end gap-2">
                                        <!-- Edit -->
                                        <a href="{{ route('categories.edit', $cat->id) }}"
                                            class="px-3 py-1.5 text-xs rounded-xl border border-blue-600 text-blue-700 bg-white hover:bg-blue-600 hover:text-white transition">
                                            Edit
                                        </a>

                                        <!-- Delete -->
                                        <form method="POST" action="{{ route('categories.destroy', $cat->id) }}"
                                            onsubmit="return confirm('Yakin hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="hidden px-3 py-1.5 text-xs rounded-xl border border-red-600 text-red-700 bg-white hover:bg-red-600 hover:text-white transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
