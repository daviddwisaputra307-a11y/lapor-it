<!DOCTYPE html>
<html>
<head>
    <title>Daftar Laporan</title>
    <style>
        body{font-family:Arial;background:#f5f7fb;margin:0;padding:30px}
        .card{max-width:900px;margin:auto;background:#fff;padding:20px;border-radius:12px;box-shadow:0 6px 20px rgba(0,0,0,.08)}
        table{width:100%;border-collapse:collapse}
        th,td{padding:12px;border-bottom:1px solid #eee;text-align:left}
        th{background:#f0f3ff}
        .badge{padding:4px 10px;border-radius:999px;font-size:12px}
        .open{background:#ffe9c7}
        .done{background:#d4ffd7}
        a.btn{display:inline-block;padding:8px 12px;background:#2563eb;color:#fff;border-radius:8px;text-decoration:none}
    </style>
</head>
<body>
<div class="card">
    <h2>📋 Daftar Laporan IT</h2>
    <div style="display:flex; gap:10px; margin-bottom:16px;">
  <a class="btn" href="/dashboard">
    ← Dashboard
  </a>

  <a class="btn" href="/tickets/create">
    + Buat Laporan
  </a>
</div>
    <table>
        <thead>
            <tr>
                <th>No Tiket</th>
                <th>Judul</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tickets as $t)
            <tr>
                <td>{{ $t->nomor_tiket ?? '-' }}</td>
                <td>{{ $t->judul }}</td>
                <td>{{ $t->lokasi }}</td>
                <td>
                    <span class="badge {{ strtolower($t->status) == 'done' ? 'done' : 'open' }}">
                        {{ $t->status ?? 'Open' }}
                    </span>
                </td>
                <td>{{ $t->created_at }}</td>
                <td><a class="btn" style="background:#111827" href="/tickets/{{ $t->id }}">Detail</a></td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada laporan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
