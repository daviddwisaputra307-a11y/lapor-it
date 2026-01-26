@extends('layouts.app')

@section('title', 'Edit Kategori - Lapor IT')

@section('content')
    <div class="max-w-[700px] mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white">
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-2xl font-bold">Edit Kategori</h1>
                    <p class="text-blue-50">Lapor IT - Perbarui Kategori Tiket Problem Solving IT</p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white border border-blue-100 rounded-2xl shadow-lg p-6">
            <form method="POST" action="{{ route('categories.update', $category->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama Kategori -->
                <div>
                    <label for="nama_kategori" class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                        Nama Kategori <span class="text-red-600">*</span>
                    </label>

                    <input type="text" id="nama_kategori" name="nama_kategori"
                        value="{{ old('nama_kategori', $category->nama_kategori) }}"
                        placeholder="Contoh: Hardware, Software, Network" autofocus required
                        class="w-full px-4 py-2.5 text-sm rounded-xl border-2 border-blue-200 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition">

                    @error('nama_kategori')
                        <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                        Deskripsi (Opsional)
                    </label>

                    <textarea id="deskripsi" name="deskripsi" placeholder="Deskripsi singkat tentang kategori ini..."
                        class="w-full min-h-[120px] px-4 py-2.5 text-sm rounded-xl border-2 border-blue-200 resize-y focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition">{{ old('deskripsi', $category->deskripsi) }}</textarea>

                    @error('deskripsi')
                        <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4">
                    <!-- Primary -->
                    <button type="submit"
                        class="inline-flex items-center gap-1 px-6 py-2.5 text-sm font-bold rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white hover:scale-105 transition-transform shadow-md">
                        Update Kategori
                    </button>

                    <!-- Secondary -->
                    <a href="{{ route('categories.index') }}"
                        class="inline-flex items-center gap-1 px-6 py-2.5 text-sm font-bold rounded-xl border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-100 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
