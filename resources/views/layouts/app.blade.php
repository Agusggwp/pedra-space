<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pedra Space' }}</title>
    <link rel="icon" href="{{ asset('storage/logo/pedra.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        @hasSection('sidebar')
            @yield('sidebar')
        @else
            @include('components.sidebar')
        @endif

        <!-- Main Content Wrapper -->
        <div class="flex-1 min-h-screen flex flex-col">
            <!-- Topbar -->
            @include('components.topbar')

            <!-- Page Content -->
            <main class="flex-1 pt-20 px-4 md:px-8">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
