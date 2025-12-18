<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pedra Space' }}</title>
    <link rel="icon" href="{{ asset('storage/logo/pedra.png') }}">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    @stack('head')
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex" id="mainWrapper">
        <!-- Sidebar -->
        @hasSection('sidebar')
            @yield('sidebar')
        @else
            @include('components.sidebar')
        @endif

        <!-- Main Content Wrapper -->
        <div class="flex-1 min-h-screen flex flex-col transition-all duration-300" id="mainContentWrapper" style="margin-left: 288px;">
            <!-- Topbar -->
            @include('components.topbar')

            <!-- Page Content -->
            <main class="flex-1 pt-20 px-4 md:px-8">
                @yield('content')
            </main>
        </div>
    </div>

    <style>
    /* Main Content Wrapper Transition */
    #mainContentWrapper {
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Mobile: Reset margin */
    @media (max-width: 1023px) {
        #mainContentWrapper {
            margin-left: 0 !important;
        }
    }
    </style>

    @stack('scripts')
</body>
</html>