{{-- resources/views/admin/tickets/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Ticket (Admin)')

@section('content')
<style>
  .wrap{max-width:1100px;margin:0 auto}
  .row{display:flex;gap:16px;flex-wrap:wrap}
  .col{flex:1;min-width:320px}

  .card{background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:18px;box-shadow:0 8px 20px rgba(15,23,42,.06)}
  .title{font-size:22px;font-weight:800;margin:0}
  .muted{color:#64748b;font-size:13px;margin-top:6px}

  .chip{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:999px;font-size:13px;font-weight:800;border:1px solid transparent}
  .chip-blue{background:#dbeafe;color:#1d4ed8;border-color:#bfdbfe}
  .chip-sky{background:#e0f2fe;color:#075985;border-color:#bae6fd}
  .chip-amber{background:#fef3c7;color:#92400e;border-color:#fde68a}
  .chip-green{background:#dcfce7;color:#166534;border-color:#bbf7d0}
  .chip-red{background:#fee2e2;color:#991b1b;border-color:#fecaca}
  .chip-slate{background:#f1f5f9;color:#334155;border-color:#e2e8f0}

  .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 14px;border-radius:10px;font-weight:900;text-decoration:none;border:1px solid transparent;cursor:pointer}
  .btn-blue{background:#2563eb;color:#fff;border-color:#2563eb}
  .btn-blue:hover{filter:brightness(.95)}
  .btn-outline{background:#fff;color:#2563eb;border-color:#2563eb}
  .btn-outline:hover{background:#eff6ff}

  label{display:block;font-size:13px;color:#475569;margin:10px 0 6px}
  select,input,textarea{width:100%;padding:10px 12px;border:1px solid #d1d5db;border-radius:10px;background:#fff}
  textarea{min-height:90px;resize:vertical}
</style>

@php
  $st = $ticket->status ?? '-';
  $statusChip = match($st){
    'Open' => 'chip-blue',
    'On Progress' => 'chip-amber',
    'Done' => 'chip-green',
    'Cancel' => 'chip-red',
    default => 'chip-slate'
  };

  $pr = $ticket->prioritas ?? '-';
  $prioChip = match($pr){
    'Low' => 'chip-slate',
    'Medium' => 'chip-sky',
    'High' => 'chip-amber',
    'Urgent' => 'chip-red',
    default => 'chip-slate'
  };
@endphp

<div class="wrap">

  {{-- Header --}}
  <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px;">
    <div>
      <h1 class="title">Detail Ticket (Admin)</h1>
      <div class="muted"></div>
    </div>

    <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline">← Kembali</a>
  </div>

  {{-- Alert --}}
  @if(session('success'))
    <div style="background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;padding:10px 12px;border-radius:12px;margin-bottom:12px;">
      {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
      <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:10px; border-radius:12px; margin-bottom:12px;">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

  {{-- Badges --}}
  <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px;">
    <span class="chip chip-blue">No: {{ $ticket->nomor_tiket ?? '-' }}</span>
    <span class="chip {{ $statusChip }}">Status: {{ $st }}</span>
    <span class="chip {{ $prioChip }}">Prioritas: {{ $pr }}</span>
    <span class="chip chip-sky">Teknisi: {{ $ticket->teknisi ?? '-' }}</span>
  </div>

  <div class="row">
    {{-- KIRI: Info Ticket --}}
    <div class="col card">
      <div style="font-weight:900;margin-bottom:10px;">Informasi Ticket</div>

      <label>Tanggal</label>
      <input value="{{ $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i:s') : '-' }}" readonly>

      <label>Lokasi</label>
      <input value="{{ $ticket->lokasi ?? '-' }}" readonly>

      <label>Judul</label>
      <input value="{{ $ticket->judul ?? '-' }}" readonly>

      <label>Deskripsi</label>
      <textarea readonly>{{ $ticket->deskripsi ?? '-' }}</textarea>
    </div>

    {{-- KANAN: Aksi --}}
    <div class="col" style="display:flex;flex-direction:column;gap:16px;">

      {{-- Assign Teknisi --}}
      <div class="card">
        <div style="font-weight:900;margin-bottom:10px;">Assign Teknisi</div>

        <form method="POST" action="{{ route('admin.tickets.assign', $ticket->id) }}">
          @csrf

          <label>Pilih teknisi</label>
          <select name="teknisi_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
              <option value="">-- Pilih Teknisi --</option>
              @foreach($teknisiList as $t)
                  <option value="{{ $t->USERLOGNM }}" {{ $ticket->teknisi == $t->USERLOGNM ? 'selected' : '' }}>
                      {{ $t->USERLOGNM }}
                  </option>
              @endforeach
          </select>

          <div style="height:12px;"></div>
          <button type="submit" class="btn btn-blue" style="width:100%;">Simpan Teknisi</button>
        </form>
      </div>

      {{-- Update Status / Prioritas --}}
      <div class="card">
        <div style="font-weight:900;margin-bottom:10px;">Update Status / Prioritas</div>

        <form method="POST" action="{{ route('admin.tickets.status', $ticket->id) }}">
          @csrf

          <label>Status</label>
          <select name="status" required>
            @foreach(['Open','On Progress','Done','Cancel'] as $s)
              <option value="{{ $s }}" {{ ($ticket->status === $s) ? 'selected' : '' }}>
                {{ $s }}
              </option>
            @endforeach
          </select>

          <label>Prioritas</label>
          <select name="prioritas">
            <option value="">-- pilih --</option>
            @foreach(['Low','Medium','High','Urgent'] as $p)
              <option value="{{ $p }}" {{ ($ticket->prioritas === $p) ? 'selected' : '' }}>
                {{ $p }}
              </option>
            @endforeach
          </select>

          <div style="height:12px;"></div>
          <button type="submit" class="btn btn-blue" style="width:100%;">Update</button>
        </form>
      </div>

    </div>
  </div>

</div>
@endsection