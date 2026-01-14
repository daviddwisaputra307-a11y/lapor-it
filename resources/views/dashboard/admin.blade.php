@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">

  <div>
    <h1 class="text-xl font-semibold text-slate-800">Dashboard Admin</h1>
    <p class="text-sm text-slate-500">Ringkasan status tiket</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
      <div class="text-sm text-slate-500">Total</div>
      <div class="text-3xl font-bold text-slate-900">{{ $total ?? 0 }}</div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
      <div class="text-sm text-slate-500">Open</div>
      <div class="text-3xl font-bold text-blue-700">{{ $open ?? 0 }}</div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
      <div class="text-sm text-slate-500">On Progress</div>
      <div class="text-3xl font-bold text-amber-600">{{ $onProgress ?? 0 }}</div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
      <div class="text-sm text-slate-500">Done</div>
      <div class="text-3xl font-bold text-green-600">{{ $done ?? 0 }}</div>
    </div>

  </div>

</div>
@endsection