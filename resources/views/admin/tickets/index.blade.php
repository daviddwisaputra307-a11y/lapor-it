<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Semua Tiket IT</title>
  <style>
    body{font-family:Arial, sans-serif;background:#f6f7fb;margin:0;padding:30px;}
    .wrap{max-width:1100px;margin:0 auto;}
    .top{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
    .card{background:#fff;border:1px solid #e6e8f0;border-radius:12px;padding:16px;box-shadow: 0 2px 4px rgba(0,0,0,0.05);}
    table{width:100%;border-collapse:collapse;}
    th,td{padding:12px;border-bottom:1px solid #eee;text-align:left;font-size:14px;}
    th{background:#fafafa;font-weight:700;}
    .badge{padding:4px 10px;border-radius:999px;font-size:12px;border:1px solid #ddd;display:inline-block;}
    .btn{display:inline-block;padding:8px 12px;border-radius:10px;background:#2563eb;color:#fff;text-decoration:none;font-size:13px;font-weight:bold;}
    .btn-red{background:#ef4444;}
    .muted{color:#6b7280;font-size:13px;}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="top">
      <div>
        <h2 style="margin:0;">🛠️ Admin - Semua Tiket</h2>
        <div class="muted">Kelola seluruh tiket penanganan IT di sini.</div>
      </div>
      <a class="btn" href="{{ route('dashboard.admin') }}">← Kembali</a>
    </div>

    <div class="card">
      <table>
        <thead>
          <tr>
            <th>No Tiket</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Teknisi</th>
            <th style="text-align:center;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tickets as $t)
            <tr>
              <td style="font-weight:bold;">{{ $t->nomor_tiket }}</td>
              <td>{{ $t->judul }}</td>
              <td><span class="badge">{{ $t->status }}</span></td>
              <td>{{ $t->teknisi ?? '-' }}</td>
              <td style="text-align:center;">
                <div style="display:flex; gap:6px; justify-content:center;">
                    <a class="btn" style="background:#4b5563;" href="{{ route('tickets.show', $t->id) }}">Detail</a>
                    <a class="btn btn-red" href="{{ route('admin.tickets.show', $t->id) }}">Edit</a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div style="margin-top:14px;">{{ $tickets->links() }}</div>
    </div>
  </div>
</body>
</html>