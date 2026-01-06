<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buat Laporan IT</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f6f7fb; margin:0; padding:24px; }
    .card { max-width:520px; margin:0 auto; background:#fff; border-radius:12px; padding:20px; box-shadow:0 8px 24px rgba(0,0,0,.08); }
    h2 { margin:0 0 14px; }
    label { display:block; margin:12px 0 6px; font-weight:600; }
    input, textarea, select { width:100%; padding:10px 12px; border:1px solid #d7dbe7; border-radius:10px; outline:none; }
    textarea { min-height:90px; resize:vertical; }
    .btn { margin-top:14px; width:100%; padding:10px 12px; border:0; border-radius:10px; background:#2f6fed; color:#fff; font-weight:700; cursor:pointer; }
    .btn:hover { filter:brightness(.95); }
    .alert { padding:10px 12px; border-radius:10px; margin-bottom:12px; }
    .success { background:#e8fff1; border:1px solid #b7f3cf; color:#146b2e; }
    .error { background:#ffecec; border:1px solid #ffb8b8; color:#8a1f1f; }
    small { color:#6b7280; }
  </style>
</head>
<body>
  <div class="card">
    <h2>🛠️ Buat Laporan IT</h2>

    @if (session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert error">
        <b>Waduh ada yang kurang:</b>
        <ul style="margin:8px 0 0 18px;">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="/tickets">
      @csrf

      <label>Judul</label>
      <input type="text" name="judul" value="{{ old('judul') }}" required>

      <label>Deskripsi</label>
      <textarea name="deskripsi" required>{{ old('deskripsi') }}</textarea>

      <label>Lokasi / Unit Kerja</label>
      <select name="lokasi" required>
        <option value="">-- pilih lokasi --</option>
        @foreach ($bagians as $b)
          <option value="{{ $b->KODEBAGIAN }}" {{ old('lokasi')==$b->KODEBAGIAN ? 'selected' : '' }}>
            {{ $b->NAMABAGIAN }}
          </option>
        @endforeach
      </select>

      <button class="btn" type="submit">Kirim Laporan</button>
    </form>
  </div>
</body>
</html>
