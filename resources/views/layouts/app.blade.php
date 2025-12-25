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

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Include Sidebar Navigation -->
    @include('layouts.navigation')

    <!-- Main Content Wrapper - Adjusted for Sidebar -->
    <div class="min-h-screen transition-all duration-300 ease-in-out lg:ml-64">

        <!-- Top Header Bar -->
        <div
            class="sticky top-0 z-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </header>
            @endif
        </div>

        <!-- Page Content -->
        <main class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer (Optional) -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    © {{ date('Y') }} Sistem Manajemen IT. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    <!-- Toast Notification -->
    <x-toast-notification />

    <!-- Additional Scripts -->
    @stack('scripts')
</body>

</html>
