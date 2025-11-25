<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'realestatecrm') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/admin-dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/a2e0e6b88d.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 ">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="w-min-screen mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif
        <div>
            <main class="flex ">
                {{-- Sidebar (fixed width or auto-sized) --}}
                <div class="w-64">
                    @include('layouts.sidebar')
                </div>

                {{-- Main Content Area (takes remaining space) --}}
                <div class="flex-1 w-screen mt-10 mb-10">
                    @yield('content')
                </div>
                {{-- Dashboard (optional, fixed width) --}}
                @if (!isset($hideDashboard))
                    <div class="w-screen">
                        @include('layouts.dashboard')
                    </div>
                @endif
            </main>
        </div>
        <!-- Page Content -->
        {{-- <main>
            @yield('content')
        </main> --}}
        <footer class="z-20 bg-black border-t border-gray-200 shadow-inner  w-full ">
            <div
                class="w-max mx-auto px-4 py-6 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} RealEstate CRM. All rights reserved.</p>
                <div class="mt-2 sm:mt-0 flex space-x-4">
                    <a href="#" class="hover:text-gray-700 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-gray-700 transition">Terms of Service</a>
                </div>
            </div>
        </footer>

    </div>
    @stack('scripts')
</body>

</html>