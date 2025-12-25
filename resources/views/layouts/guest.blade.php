<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Background Container with proper centering -->
    <div class="min-h-screen relative flex items-center justify-center p-4 sm:p-6 lg:p-8">

        <!-- Background Image -->
        <div style="background-image: url('{{ asset('images/MAN1.jpg') }}')"
            class="absolute inset-0 bg-cover bg-center bg-no-repeat"></div>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50 dark:bg-black/70 backdrop-blur-sm"></div>

        <!-- Content - Properly Centered -->
        <div class="relative z-10 w-full max-w-md">
            <div
                class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-md shadow-2xl rounded-2xl overflow-hidden border border-white/20">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
