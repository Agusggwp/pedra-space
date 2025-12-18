<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pedra Space' }}</title>
    <link rel="icon" href="{{ asset('storage/logo/pedra.png') }}">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('head')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Sidebar -->
    @hasSection('sidebar')
        @yield('sidebar')
    @else
        @include('components.sidebar')
    @endif

    <!-- Main Content Wrapper -->
    <div id="mainContentWrapper" class="min-h-screen flex flex-col transition-all duration-300">
        <!-- Topbar -->
        @include('components.topbar')

        <!-- Page Content -->
        <main class="flex-1 pt-20 px-4 md:px-8">
            @yield('content')
        </main>
    </div>

    <style>
    /* Main Content Wrapper dengan margin dinamis */
    #mainContentWrapper {
        margin-left: 0;
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Desktop: Margin mengikuti sidebar */
    @media (min-width: 1024px) {
        #mainContentWrapper {
            margin-left: 288px; /* Sidebar normal */
        }

        /* Ketika sidebar collapsed */
        #sidebar.sidebar-collapsed ~ #mainContentWrapper {
            margin-left: 85px; /* Sidebar kecil */
        }
    }

    /* Mobile & Tablet: No margin (sidebar overlay) */
    @media (max-width: 1023px) {
        #mainContentWrapper {
            margin-left: 0 !important;
        }
    }
    </style>

    <script>
    // Sinkronisasi margin main content dengan sidebar state
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContentWrapper');

        function syncMainContent() {
            if (window.innerWidth >= 1024) {
                if (sidebar.classList.contains('sidebar-collapsed')) {
                    mainContent.style.marginLeft = '85px';
                } else {
                    mainContent.style.marginLeft = '288px';
                }
            } else {
                mainContent.style.marginLeft = '0';
            }
        }

        // Jalankan saat load
        syncMainContent();

        // Observer untuk detect perubahan class sidebar
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    syncMainContent();
                }
            });
        });

        observer.observe(sidebar, { attributes: true });

        // Sync saat resize
        window.addEventListener('resize', syncMainContent);
    });
    </script>

    @stack('scripts')
</body>
</html>