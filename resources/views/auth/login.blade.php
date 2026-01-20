<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-4 text-center">
        <h2 class="text-xl font-bold">Login Karyawan</h2>
        <p class="text-gray-500">Silakan masuk untuk melapor</p>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="uslognm" :value="__('Username')" />
            <x-text-input id="uslognm" class="block mt-1 w-full" type="text" name="uslognm" :value="old('uslognm')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('uslognm')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Bagian Remember Me dan Forgot Password sudah dihapus untuk menghindari error --}}

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-3 whitespace-nowrap w-auto px-6">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>