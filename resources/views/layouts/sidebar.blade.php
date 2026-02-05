
    <aside class="w-64 bg-gradient-to-b from-blue-700 to-blue-600 text-white flex flex-col min-h-screen shadow-xl">

    {{-- HEADER --}}
    <div class="px-6 py-6 border-b border-blue-800">
        <a href="/" class="flex items-center gap-2">
            <div>
                <div class="text-xl font-extrabold tracking-wide">Lapor IT</div>
                <div class="text-xs text-blue-100">Platform Tiketing IT</div>
            </div>
        </a>
    </div>

    {{-- USER INFO --}}
    <div class="px-6 py-4 border-b border-blue-800 bg-white/10 backdrop-blur-sm">
        @php
            $uslognm = Auth::user()->USLOGNM ?? null;
            $userlogid = $uslognm ? \App\Models\USERLOG_ID::where('USERLOGNM', $uslognm)->first() : null;
            $role = \App\Models\USERLOG_ROLES::where('USERLOGNM', $uslognm)->value('USERLOG_ROLES') ?? 'user';
        @endphp
        <div class="flex items-center gap-2 mb-2">
            <div class="flex-1">
                <div class="text-sm font-bold">{{ $userlogid->USERLOGNM ?? '-' }}</div>
                <div class="text-xs text-blue-100">{{ $userlogid->KETERANGAN ?? '-' }}</div>
            </div>
        </div>

        <div class="text-[11px] inline-flex items-center gap-1 px-2 py-1 rounded-full bg-blue-800 text-white font-semibold">
            {{ ucfirst($role) }}
        </div>
    </div>

    {{-- NAV --}}
    <nav class="flex-1 px-3 py-4 space-y-2">

        <a href="/"
            class="flex items-center gap-2 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition font-semibold
           {{ request()->routeIs('dashboard') ? 'bg-blue-800 shadow-lg' : '' }}">
            Dashboard
        </a>

        <hr class="border-blue-800 my-4">
        <div class="text-[10px] uppercase tracking-widest text-blue-200 px-3 mt-4 mb-2 font-bold">User Menu</div>     {{-- BUAT LAPORAN --}}
        <a href="{{ route('tickets.create') }}"
            class="flex items-center gap-2 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition font-semibold
           {{ request()->routeIs('tickets.create') ? 'bg-blue-800 shadow-lg' : '' }}">
            Buat Laporan
        </a>

        {{-- RIWAYAT TIKET --}}
        <a href="{{ route('tickets.index') }}"
            class="flex items-center gap-2 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition font-semibold
           {{ request()->routeIs('tickets.index') || request()->routeIs('tickets.show') ? 'bg-blue-800 shadow-lg' : '' }}">
            Riwayat Tiket
        </a>

        {{-- ADMIN MENU --}}
        @if ($role === 'admin')
            <hr class="border-blue-800 my-4">
            <div class="text-[10px] uppercase tracking-widest text-blue-200 px-3 mt-4 mb-2 font-bold">Admin Menu</div>

            <a href="{{ route('admin.tickets.index') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition font-semibold
               {{ request()->routeIs('admin.tickets.*') ? 'bg-blue-800 shadow-lg' : '' }}">
                Tiket Admin
            </a>

            {{-- MENU CATEGORIES --}}
            <a href="{{ route('categories.index') }}"
                class="flex items-center gap-2 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition font-semibold
                {{ request()->routeIs('categories.*') ? 'bg-blue-800 shadow-lg' : '' }}">
                Kelola Kategori
            </a>
        @endif

    </nav>

    {{-- LOGOUT --}}
    <div class="p-4 border-t border-blue-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition shadow-md">
                Logout
            </button>
        </form>
    </div>

</aside>
