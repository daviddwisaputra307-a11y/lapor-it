<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Daftar Tiket</title>
  <style>
    body{font-family:Arial, sans-serif;background:#f6f7fb;margin:0;padding:30px;}
    .wrap{max-width:1000px;margin:0 auto;}
    .top{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
    .card{background:#fff;border:1px solid #e6e8f0;border-radius:12px;padding:16px;}
    table{width:100%;border-collapse:collapse;}
    th,td{padding:12px;border-bottom:1px solid #eee;text-align:left;font-size:14px;}
    th{background:#fafafa;font-weight:700;}
    .badge{padding:4px 10px;border-radius:999px;font-size:12px;border:1px solid #ddd;display:inline-block;}
    .btn{display:inline-block;padding:8px 12px;border-radius:10px;background:#2563eb;color:#fff;text-decoration:none;font-size:13px;}
    .muted{color:#6b7280;font-size:13px;}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="top">
      <div>
        <h2 style="margin:0;">🛠️ Admin - Semua Tiket</h2>
        <div class="muted">Lihat semua tiket, cek detail, assign teknisi, ubah status.</div>
      </div>
      <a class="btn" href="{{ route('tickets.index') }}">↩ Ke User List</a>
    </div>

    <div class="card">
      <table>
        <thead>
          <tr>
            <th>No Tiket</th>
            <th>Judul</th>
            <th>Lokasi</th>
            <th>Prioritas</th>
            <th>Status</th>
            <th>Teknisi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tickets as $t)
            <tr>
              <td>{{ $t->nomor_tiket }}</td>
              <td>{{ $t->judul }}</td>
              <td>{{ $t->lokasi }}</td>
              <td><span class="badge">{{ $t->prioritas ?? '-' }}</span></td>
              <td><span class="badge">{{ $t->status }}</span></td>
              <td>{{ $t->teknisi ?? '-' }}</td>
              <td>
                <a class="btn" href="{{ route('admin.tickets.show', $t->id) }}">Detail</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div style="margin-top:14px;">
        {{ $tickets->links() }}
      </div>
    </div>
  </div>
</body>
</html>
