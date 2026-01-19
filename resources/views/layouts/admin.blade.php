<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'LaporIT') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    {{-- TOPBAR ADMIN --}}
    <header class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div>
                <div class="text-lg font-bold">Admin Panel</div>
                <div class="text-xs text-gray-500">{{ config('app.name', 'LaporIT') }}</div>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-sm">
                    <span class="font-semibold">{{ Auth::user()->name ?? '-' }}</span>
                    <span class="text-gray-500">({{ Auth::user()->USERLOG_ROLES ?? 'user' }})</span>
                </div>

                {{-- tombol balik --}}
                <a href="{{ route('admin.tickets.index') }}"
                   class="px-3 py-2 rounded bg-slate-800 text-white text-sm hover:bg-slate-900">
                    ← Tiket Admin
                </a>

                {{-- logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="px-3 py-2 rounded bg-red-600 text-white text-sm hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="max-w-6xl mx-auto px-6 py-6">
        @yield('content')
    </main>
</body>
</html>