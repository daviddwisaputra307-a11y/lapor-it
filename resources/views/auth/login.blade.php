<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Lapor IT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-200 via-white to-blue-400 py-8 px-2">
    <div class="w-full max-w-md bg-white/80 shadow-xl rounded-3xl p-8 backdrop-blur-md border border-blue-100 relative">
        <div class="flex flex-col items-center mb-6">
            <div class="bg-gradient-to-tr from-blue-500 to-cyan-400 rounded-full p-3 shadow-lg mb-2">
                <span class="material-icons text-white text-4xl">medical_services</span>
            </div>
            <h1 class="text-3xl font-extrabold text-blue-700 tracking-tight mb-1">Lapor IT</h1>
            <p class="text-sm text-blue-500 font-medium mb-2">Platform Tiketing Problem Solving IT Rumah Sakit</p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="uslognm" class="block text-blue-700 font-semibold mb-1">Username</label>
                <input id="uslognm" class="block w-full rounded-xl border-blue-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-200 shadow-sm px-4 py-2 border" type="text" name="uslognm" value="{{ old('uslognm') }}" required autofocus autocomplete="username" />
                @error('uslognm')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-blue-700 font-semibold mb-1">Password</label>
                <input id="password" class="block w-full rounded-xl border-blue-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-200 shadow-sm px-4 py-2 border" type="password" name="password" required autocomplete="current-password" />
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between mt-6">
                <span class="text-xs text-gray-400">© {{ date('Y') }} Lapor IT</span>
                <button type="submit" class="w-auto px-8 py-2 bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold rounded-xl shadow hover:scale-105 transition-transform flex items-center">
                    <span class="material-icons align-middle mr-1 text-base">login</span> Log in
                </button>
            </div>
        </form>
    </div>
</body>
</html>
