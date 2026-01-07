<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buat Laporan IT</title>

  <style>
    :root{
      --bg: #f5f7fb;
      --card: #ffffff;
      --text: #0f172a;
      --muted: #64748b;
      --border: #e2e8f0;
      --primary: #2563eb;
      --primary-hover: #1d4ed8;
      --danger: #ef4444;
      --success-bg: #dcfce7;
      --success-text: #166534;
      --shadow: 0 10px 30px rgba(2, 6, 23, .08);
      --radius: 14px;
    }

    *{ box-sizing: border-box; }
    body{
      margin:0;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background: var(--bg);
      color: var(--text);
    }

    .wrap{
      min-height: 100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding: 28px 16px;
    }

    .card{
      width: min(720px, 100%);
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow:hidden;
    }

    .card-header{
      padding: 18px 20px;
      border-bottom: 1px solid var(--border);
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 12px;
    }

    .title{
      display:flex;
      align-items:center;
      gap:10px;
      font-weight: 800;
      font-size: 18px;
      margin:0;
    }

    .sub{
      margin: 4px 0 0;
      color: var(--muted);
      font-size: 13px;
    }

    .back{
      text-decoration:none;
      font-size: 13px;
      padding: 8px 12px;
      border: 1px solid var(--border);
      border-radius: 10px;
      color: var(--text);
      background: #fff;
    }
    .back:hover{ background:#f8fafc; }

    .card-body{
      padding: 18px 20px 20px;
    }

    .alert-success{
      margin-bottom: 14px;
      padding: 10px 12px;
      background: var(--success-bg);
      color: var(--success-text);
      border: 1px solid #86efac;
      border-radius: 10px;
      font-size: 14px;
    }

    .alert-error{
      margin-bottom: 14px;
      padding: 10px 12px;
      background: #fee2e2;
      color: #991b1b;
      border: 1px solid #fecaca;
      border-radius: 10px;
      font-size: 14px;
    }

    .grid{
      display:grid;
      grid-template-columns: 1fr;
      gap: 14px;
    }

    label{
      display:block;
      font-weight: 700;
      font-size: 13px;
      margin-bottom: 6px;
    }

    .hint{
      color: var(--muted);
      font-size: 12px;
      margin-top: 6px;
    }

    input, textarea, select{
      width: 100%;
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 12px 12px;
      font-size: 14px;
      outline: none;
      background: #fff;
    }
    textarea{ resize: vertical; min-height: 120px; }
    input:focus, textarea:focus, select:focus{
      border-color: #93c5fd;
      box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
    }

    .row-2{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }
    @media (max-width: 640px){
      .row-2{ grid-template-columns: 1fr; }
    }

    .actions{
      display:flex;
      gap: 10px;
      align-items:center;
      justify-content:flex-end;
      margin-top: 18px;
      padding-top: 14px;
      border-top: 1px dashed var(--border);
    }

    .btn{
      border: 0;
      border-radius: 12px;
      padding: 12px 14px;
      font-weight: 800;
      cursor:pointer;
      font-size: 14px;
    }
    .btn-primary{
      background: var(--primary);
      color: white;
      min-width: 160px;
    }
    .btn-primary:hover{ background: var(--primary-hover); }

    .btn-ghost{
      background: #fff;
      border: 1px solid var(--border);
      color: var(--text);
    }
    .btn-ghost:hover{ background: #f8fafc; }

    .field-error{
      color: var(--danger);
      font-size: 12px;
      margin-top: 6px;
      font-weight: 700;
    }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <div class="card-header">
        <div>
          <h1 class="title">🛠️ Buat Laporan IT</h1>
        </div>

        <a class="back" href="{{ route('tickets.index') }}">← Daftar Laporan</a>
      </div>

      <div class="card-body">
        @if (session('success'))
          <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
          <div class="alert-error">
          </div>
        @endif

        <form method="POST" action="{{ route('tickets.store') }}">
          @csrf

          <div class="grid">
            <div>
              <label for="judul">Judul</label>
              <input
                id="judul"
                type="text"
                name="judul"
                value="{{ old('judul') }}"
                placeholder="Contoh: Printer error / WiFi lemot / PC bluescreen"
                required
              >
              @error('judul')
                <div class="field-error">{{ $message }}</div>
              @enderror
            </div>

            <div>
              <label for="deskripsi">Deskripsi</label>
              <textarea
                id="deskripsi"
                name="deskripsi"
                placeholder="Jelasin singkat: masalahnya apa, kapan kejadian, ada pesan error apa..."
                required
              >{{ old('deskripsi') }}</textarea>
              @error('deskripsi')
                <div class="field-error">{{ $message }}</div>
              @enderror
            </div>

            <div class="row-2">
              <div>
                <label for="lokasi">Lokasi / Unit Kerja</label>
                <select id="lokasi" name="lokasi" required>
                  <option value="">— pilih lokasi —</option>
                  @foreach ($bagians as $b)
                    <option value="{{ $b->KODEBAGIAN }}" {{ old('lokasi') == $b->KODEBAGIAN ? 'selected' : '' }}>
                      {{ $b->NAMABAGIAN }}
                    </option>
                  @endforeach
                </select>
                @error('lokasi')
                  <div class="field-error">{{ $message }}</div>
                @enderror
              </div>

              <div>
                <label for="prioritas">Prioritas</label>
                <select id="prioritas" name="prioritas">
                  @php $p = old('prioritas', 'Low'); @endphp
                  <option value="Low" {{ $p=='Low' ? 'selected' : '' }}>Low</option>
                  <option value="Medium" {{ $p=='Medium' ? 'selected' : '' }}>Medium</option>
                  <option value="High" {{ $p=='High' ? 'selected' : '' }}>High</option>
                  <option value="Urgent" {{ $p=='Urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
              </div>
            </div>

            <div class="actions">
              <a class="btn btn-ghost" href="{{ route('tickets.index') }}">Batal</a>
              <button class="btn btn-primary" type="submit">Kirim Laporan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
