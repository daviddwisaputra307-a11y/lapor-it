<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Kategori</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 font-sans p-8">
    <div class="max-w-[600px] mx-auto">

        <!-- Header -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold m-0">➕ Tambah Kategori Baru</h2>
            <div class="text-sm text-slate-500">
                Isi form di bawah untuk menambah kategori
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <!-- Nama Kategori -->
                <div class="mb-4">
                    <label for="nama_kategori" class="block text-sm font-semibold text-slate-700 mb-1">
                        Nama Kategori <span class="text-red-600">*</span>
                    </label>

                    <input type="text" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}"
                        placeholder="Contoh: Hardware, Software, Network" autofocus required
                        class="w-full px-3 py-2 text-sm rounded-lg
                                  border border-slate-300
                                  focus:outline-none focus:ring-4
                                  focus:ring-blue-100 focus:border-blue-600">

                    @error('nama_kategori')
                        <div class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1">
                        Deskripsi (Opsional)
                    </label>

                    <textarea id="deskripsi" name="deskripsi" placeholder="Deskripsi singkat tentang kategori ini..."
                        class="w-full min-h-[100px] px-3 py-2 text-sm rounded-lg
                                     border border-slate-300 resize-y
                                     focus:outline-none focus:ring-4
                                     focus:ring-blue-100 focus:border-blue-600">{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <div class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-3 mt-5">
                    <!-- Primary -->
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl
                                   border border-blue-600 text-blue-700 bg-white
                                   hover:bg-blue-600 hover:text-white
                                   transition">
                        Simpan Kategori
                    </button>

                    <!-- Secondary -->
                    <a href="{{ route('categories.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl
                              border border-slate-300 text-slate-600 bg-white
                              hover:bg-slate-200
                              transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
