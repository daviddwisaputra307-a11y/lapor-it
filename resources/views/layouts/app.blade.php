<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'LaporIT') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">
<div class="min-h-screen flex">

  {{-- SIDEBAR --}}
  @include('layouts.sidebar')

  {{-- WRAPPER KANAN --}}
  <div class="flex-1 flex flex-col">

    {{-- HEADER / TOP BAR --}}
    <div class="h-14 bg-white border-b flex items-center justify-end px-6">
      <a href="{{ route('admin.tickets.index') }}" class="relative">
        <svg xmlns="http://www.w3.org/2000/svg"
          class="w-6 h-6 text-slate-600 hover:text-blue-600"
          fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 01-6 0" />
        </svg>

        @if($notifCount ?? 0 > 0)
          <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px]
            w-5 h-5 flex items-center justify-center rounded-full">
            {{ $notifCount }}
          </span>
        @endif
      </a>
    </div>

    {{-- CONTENT --}}
    <main class="flex-1 p-6">
      @yield('content')
    </main>

  </div>

</div>
</body>
</html>