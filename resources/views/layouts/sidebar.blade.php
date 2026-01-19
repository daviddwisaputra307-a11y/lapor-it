<aside class="w-64 bg-slate-900 text-slate-100 flex flex-col">

    {{-- HEADER --}}
    <div class="px-6 py-5 border-b border-slate-700">
        <div class="text-lg font-bold tracking-wide">
            {{ config('app.name', 'LaporIT') }}
        </div>
        <div class="text-xs text-slate-300 mt-1">Menu</div>
    </div>

    {{-- USER INFO --}}
    <div class="px-6 py-4 border-b border-slate-700">
        @php
            $uslognm = Auth::user()->USLOGNM ?? null;
            $userlogid = $uslognm ? \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first() : null;
            $role = \App\Models\USERLOG_ROLES::where('USERLOGNM', $uslognm)->value('USERLOG_ROLES') ?? 'user';
        @endphp
        <div class="text-sm font-semibold">{{ $userlogid->USERLOGNM ?? '-' }}</div>
        <div class="text-xs text-slate-300">{{ $userlogid->KETERANGAN ?? '-' }}</div>

        <div class="text-[11px] mt-2 inline-block px-2 py-1 rounded bg-slate-800 text-slate-200">
            Role: {{ $role }}
        </div>
    </div>

    {{-- NAV --}}
    <nav class="flex-1 px-3 py-4 space-y-2">

        <div class="text-xs uppercase tracking-widest text-slate-400 px-3 mt-4">User</div>

        {{-- BUAT LAPORAN --}}
        <a href="{{ route('tickets.create') }}"
            class="block px-3 py-2 rounded hover:bg-slate-800
           {{ request()->routeIs('tickets.create') ? 'bg-slate-800' : '' }}">
            ➕ Buat Laporan
        </a>

        {{-- RIWAYAT TIKET --}}
        <a href="{{ route('tickets.index') }}"
            class="block px-3 py-2 rounded hover:bg-slate-800
           {{ request()->routeIs('tickets.index') || request()->routeIs('tickets.show') ? 'bg-slate-800' : '' }}">
            🧾 Riwayat Tiket
        </a>

        {{-- ADMIN MENU --}}
        @if ($role === 'admin')
            <div class="text-xs uppercase tracking-widest text-slate-400 px-3 mt-4">Admin</div>

            <a href="{{ route('admin.tickets.index') }}"
                class="block px-3 py-2 rounded hover:bg-slate-800
               {{ request()->routeIs('admin.tickets.*') ? 'bg-slate-800' : '' }}">
                🗂️ Tiket Admin
            </a>

            {{-- MENU CATEGORIES --}}
            <a href="{{ route('categories.index') }}"
                class="block px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('categories.*') ? 'bg-slate-800' : '' }}">
                📂 Kelola Kategori
            </a>
        @endif

    </nav>

    {{-- LOGOUT --}}
    <div class="p-3 border-t border-slate-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full px-3 py-2 rounded bg-red-600 hover:bg-red-700 text-white">
                Logout
            </button>
        </form>
    </div>

</aside>
