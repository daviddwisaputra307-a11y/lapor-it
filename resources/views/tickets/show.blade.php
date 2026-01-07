<!DOCTYPE html>
<html>
<head>
    <title>Detail Laporan</title>
    <style>
        body{font-family:Arial;background:#f5f7fb;margin:0;padding:30px}
        .card{max-width:700px;margin:auto;background:#fff;padding:20px;border-radius:12px;box-shadow:0 6px 20px rgba(0,0,0,.08)}
        .row{margin:10px 0}
        .label{color:#6b7280;font-size:13px}
        .val{font-size:16px}
        a.btn{display:inline-block;padding:8px 12px;background:#2563eb;color:#fff;border-radius:8px;text-decoration:none}
    </style>
</head>
<body>
<div class="card">
    <h2>🧾 Detail Laporan</h2>

    <div class="row"><div class="label">Nomor Tiket</div><div class="val">{{ $ticket->nomor_tiket ?? '-' }}</div></div>
    <div class="row"><div class="label">Judul</div><div class="val">{{ $ticket->judul }}</div></div>
    <div class="row"><div class="label">Deskripsi</div><div class="val">{{ $ticket->deskripsi }}</div></div>
    <div class="row"><div class="label">Lokasi</div><div class="val">{{ $ticket->lokasi }}</div></div>
    <div class="row"><div class="label">Status</div><div class="val">{{ $ticket->status ?? 'Open' }}</div></div>
    <div class="row"><div class="label">Tanggal</div><div class="val">{{ $ticket->created_at }}</div></div>

    <p><a class="btn" href="/tickets">⬅ Kembali</a></p>
</div>
</body>
</html>
