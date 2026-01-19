<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPOR IT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex">

    <!-- SIDEBAR KIRI -->
    <div class="w-64 bg-white border-r">
        @include('layouts.sidebar')
    </div>

    <!-- KONTEN KANAN -->
    <div class="flex-1">
        <div class="p-6">
            @yield('content')
        </div>
    </div>

</div>

</body>
</html>