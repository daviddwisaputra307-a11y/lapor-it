@extends('layouts.app')

@section('title', 'Dashboard Admin - Lapor IT')

@section('content')
<div class="space-y-6">

  <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white">
    <div class="flex items-center gap-3">
      <div>
        <h1 class="text-2xl font-bold">Dashboard Admin</h1>
        <p class="text-blue-50">Lapor IT - Platform Tiketing Problem Solving IT Rumah Sakit</p>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

    <div class="bg-white border border-blue-200 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
      <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Total</span>
      </div>
      <div class="text-4xl font-extrabold text-slate-900">{{ $total ?? 0 }}</div>
      <div class="text-sm text-slate-500 mt-1">Semua Tiket</div>
    </div>

    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-300 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
      <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-medium text-blue-700 bg-blue-200 px-2 py-1 rounded-full">Open</span>
      </div>
      <div class="text-4xl font-extrabold text-blue-700">{{ $open ?? 0 }}</div>
      <div class="text-sm text-blue-600 mt-1">Tiket Menunggu</div>
    </div>

    <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-300 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
      <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-medium text-amber-700 bg-amber-200 px-2 py-1 rounded-full">Progress</span>
      </div>
      <div class="text-4xl font-extrabold text-amber-600">{{ $onProgress ?? 0 }}</div>
      <div class="text-sm text-amber-600 mt-1">Sedang Dikerjakan</div>
    </div>

    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-300 rounded-2xl p-5 shadow-md hover:shadow-xl transition-shadow">
      <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-medium text-green-700 bg-green-200 px-2 py-1 rounded-full">Done</span>
      </div>
      <div class="text-4xl font-extrabold text-green-600">{{ $done ?? 0 }}</div>
      <div class="text-sm text-green-600 mt-1">Tiket Selesai</div>
    </div>

  </div>

</div>
@endsection
