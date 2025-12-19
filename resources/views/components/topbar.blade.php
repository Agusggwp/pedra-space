<!-- TOPBAR -->
<header id="topbar" class="fixed top-0 right-0 z-40 bg-white border-b border-gray-200 px-4 py-3 shadow-sm transition-all duration-300 lg:left-72">
    <div class="flex items-center justify-between w-full">
        <!-- LEFT: Menu Button (Selalu Tampil) -->
        <div class="flex items-center gap-4">
            <button id="menuBtn" class="bg-blue-600 text-white hover:bg-blue-700 transition-all p-2 rounded-lg shadow-md flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- RIGHT: User Info -->
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center gap-2 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full border border-blue-100">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                <span class="text-xs font-bold uppercase tracking-wider">{{ auth()->user()->role }}</span>
            </div>

            <div class="flex items-center gap-3 pl-4 border-l border-gray-100">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-900 leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-blue-500 font-medium">Aktif</p>
                </div>
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold shadow-sm border-2 border-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </div>
</header>

<style>
/* Topbar Positioning */
#topbar {
    left: 0;
    transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Desktop: Default position with sidebar */
@media (min-width: 1024px) {
    #topbar {
        left: 288px;
    }
    
    /* When sidebar is collapsed */
    #sidebar.sidebar-collapsed ~ * #topbar,
    body:has(#sidebar.sidebar-collapsed) #topbar {
        left: 85px;
    }
}

/* Rotate icon when sidebar collapsed (Desktop only) */
@media (min-width: 1024px) {
    #sidebar.sidebar-collapsed ~ * #menuIcon,
    body:has(#sidebar.sidebar-collapsed) #menuIcon {
        transform: rotate(180deg);
    }
}

/* Content area adjustment - Expand/Shrink with sidebar */
@media (min-width: 1024px) {
    /* Default state with sidebar expanded */
    #sidebar:not(.sidebar-collapsed) ~ .flex-1 {
        margin-left: 288px;
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Collapsed state - content expands */
    #sidebar.sidebar-collapsed ~ .flex-1 {
        margin-left: 85px;
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
}

/* Mobile - no margin needed */
@media (max-width: 1023px) {
    #sidebar ~ .flex-1 {
        margin-left: 0 !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const topbar = document.getElementById('topbar');
    const overlay = document.getElementById('overlay');

    if (!menuBtn || !sidebar || !topbar) {
        console.error('Required elements not found');
        return;
    }

    // Function to sync topbar position
    function syncTopbar() {
        const width = window.innerWidth;
        
        if (width >= 1024) {
            // Desktop
            if (sidebar.classList.contains('sidebar-collapsed')) {
                topbar.style.left = '85px';
            } else {
                topbar.style.left = '288px';
            }
        } else {
            // Mobile & Tablet
            topbar.style.left = '0';
        }
    }

    // Toggle sidebar
    function toggleSidebar() {
        const isMobile = window.innerWidth < 1024;

        if (isMobile) {
            // Mobile & Tablet: Slide in/out
            sidebar.classList.toggle('-translate-x-full');
            if (overlay) {
                overlay.classList.toggle('hidden');
            }
        } else {
            // Desktop: Collapse/expand
            sidebar.classList.toggle('sidebar-collapsed');
            
            // Save state
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('sidebar-collapsed'));
            
            // Sync topbar
            syncTopbar();
        }
    }

    // Menu button click
    menuBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        toggleSidebar();
    });

    // Overlay click (close sidebar on mobile)
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    }

    // Close sidebar when clicking links (mobile only)
    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
                if (overlay) {
                    overlay.classList.add('hidden');
                }
            }
        });
    });

    // Restore saved state on desktop
    if (window.innerWidth >= 1024) {
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            sidebar.classList.add('sidebar-collapsed');
        }
    }

    // Initial sync
    syncTopbar();

    // Sync on resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(syncTopbar, 100);
    });
});
</script>