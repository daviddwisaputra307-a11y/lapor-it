<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Detail Tiket</title>
  <style>
    body{font-family:Arial, sans-serif;background:#f6f7fb;margin:0;padding:30px;}
    .wrap{max-width:900px;margin:0 auto;}
    .card{background:#fff;border:1px solid #e6e8f0;border-radius:12px;padding:18px;margin-bottom:14px;}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
    label{font-size:12px;color:#6b7280;display:block;margin-bottom:6px;}
    input,select,textarea{width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;}
    textarea{min-height:120px;resize:vertical;}
    .btn{display:inline-block;padding:10px 14px;border-radius:10px;background:#2563eb;color:#fff;text-decoration:none;border:none;cursor:pointer;}
    .btn2{background:#111827;}
    .pill{display:inline-block;padding:4px 10px;border-radius:999px;border:1px solid #ddd;font-size:12px;}
    .top{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;}
    .success{background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;padding:10px;border-radius:10px;margin-bottom:12px;}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="top">
      <h2 style="margin:0;">📄 Detail Tiket (Admin)</h2>
      <a class="btn btn2" href="{{ route('admin.tickets.index') }}">← Kembali</a>
    </div>

    @if(session('success'))
      <div class="success">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <div class="pill">No: <b>{{ $ticket->nomor_tiket }}</b></div>
        <div class="pill">Status: <b>{{ $ticket->status }}</b></div>
        <div class="pill">Prioritas: <b>{{ $ticket->prioritas ?? '-' }}</b></div>
        <div class="pill">Teknisi: <b>{{ $ticket->teknisi ?? '-' }}</b></div>
      </div>
      <hr style="border:none;border-top:1px solid #eee;margin:14px 0;">

   <div class="row g-3">
  <div class="col-12 col-md-8">
    <label class="form-label mb-1">Judul</label>
    <input type="text" class="form-control w-100" value="{{ $ticket->judul }}" readonly>
  </div>

  <div class="col-12 col-md-4">
    <label class="form-label mb-1">Lokasi</label>
    <input type="text" class="form-control w-100" value="{{ $ticket->lokasi }}" readonly>
  </div>
</div>

<div class="mt-3">
  <label class="form-label mb-1">Deskripsi</label>
  <textarea class="form-control w-100" rows="4" readonly>{{ $ticket->deskripsi }}</textarea>
</div>

<hr class="my-4">

    <div class="card">
      <h3 style="margin:0 0 10px 0;">Assign Teknisi</h3>
      <form method="POST" action="{{ route('admin.tickets.assign', $ticket->id) }}">
        @csrf
        <div class="row">
          <div>
            <label>Pilih Teknisi</label>
            <select name="teknisi" required>
              <option value="">-- pilih --</option>
              @foreach($teknisiList as $tek)
                <option value="{{ $tek }}" @selected($ticket->teknisi === $tek)>{{ $tek }}</option>
              @endforeach
            </select>
          </div>
          <div style="display:flex;align-items:end;">
            <button class="btn" type="submit">Simpan Teknisi</button>
          </div>
        </div>
      </form>
    </div>

    <div class="card">
      <h3 style="margin:0 0 10px 0;">Ubah Status / Prioritas</h3>
      <form method="POST" action="{{ route('admin.tickets.status', $ticket->id) }}">
        @csrf
        <div class="row">
          <div>
            <label>Status</label>
            <select name="status" required>
              @foreach(['Open','On Progress','Done','Cancel'] as $s)
                <option value="{{ $s }}" @selected($ticket->status === $s)>{{ $s }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label>Prioritas</label>
            <select name="prioritas">
              <option value="">(biarin)</option>
              @foreach(['Low','Medium','High','Urgent'] as $p)
                <option value="{{ $p }}" @selected($ticket->prioritas === $p)>{{ $p }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div style="margin-top:12px;">
          <button class="btn" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
