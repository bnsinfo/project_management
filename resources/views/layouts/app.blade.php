<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!-- Alpine.js CDN -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Optional: Your custom CSS file -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Optional: Your custom JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="min-h-screen bg-gray-100" style="height:100vh;">

        {{-- NAVIGATION BAR --}}
        <div class="flex" style="height:100%;">

            @include('layouts.sidebar')

            {{-- PAGE CONTENT --}}
            <main class="flex-1 transition-all duration-300">
                @include('layouts.navigation')

                <div class="content-main p-6">
                    {{ $slot }}
                </div>
            </main>

        </div>

    </div>
</body>

</html>
