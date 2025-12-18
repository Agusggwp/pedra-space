<!-- TOPBAR COMPONENT -->
<header id="topbar" class="fixed top-0 right-0 z-40 bg-white border-b border-gray-200 px-4 py-3 shadow-sm transition-all duration-300" style="left: 288px;">
    <div class="flex items-center justify-between w-full">
        <div class="flex items-center gap-4">
            <button id="menuBtn" class="bg-emerald-600 text-white hover:bg-emerald-700 transition-all p-2 rounded-lg shadow-md flex items-center justify-center focus:outline-none">
                <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div class="flex items-center gap-4">
            <!-- <div class="hidden md:flex items-center gap-2 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full border border-emerald-100">
                <span class="text-[10px] font-bold uppercase tracking-wider">{{ auth()->user()->role }}</span>
            </div> -->

            <div class="flex items-center gap-3 pl-4 border-l border-gray-100">
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-900 leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-emerald-500 font-medium">Aktif</p>
                </div>
                <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white font-bold shadow-sm border-2 border-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </div>
</header>

<style>
/* Default Desktop */
#topbar {
    left: 288px;
    transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Jika Sidebar Kecil (Desktop) */
#sidebar.sidebar-collapsed ~ #topbar {
    left: 85px;
}

#sidebar.sidebar-collapsed ~ #topbar #menuIcon {
    transform: rotate(180deg);
}

/* Pengaturan Mobile */
@media (max-width: 1023px) {
    #topbar {
        left: 0 !important;
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>

<!-- SCRIPT HAMBURGER MENU -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (menuBtn && sidebar) {
            menuBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                // On mobile: slide sidebar in/out
                // On desktop: toggle collapse/expand
                if (window.innerWidth < 1024) {
                    sidebar.classList.toggle('-translate-x-full');
                    if (overlay) {
                        overlay.classList.toggle('hidden');
                    }
                } else {
                    // On desktop, always expand if collapsed
                    if (sidebar.classList.contains('sidebar-collapsed')) {
                        sidebar.classList.remove('sidebar-collapsed');
                    } else {
                        sidebar.classList.add('sidebar-collapsed');
                    }
                }
            });

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }

            // Tutup sidebar saat klik link (mobile only)
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
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const topbar = document.getElementById('topbar');
    const overlay = document.getElementById('overlay');

    // Fungsi untuk mengatur posisi Topbar berdasarkan status Sidebar
    function syncTopbar() {
        if (window.innerWidth >= 1024) {
            if (sidebar.classList.contains('sidebar-collapsed')) {
                topbar.style.left = '85px';
            } else {
                topbar.style.left = '288px';
            }
        } else {
            topbar.style.left = '0';
        }
    }

    // Event Klik Tombol Menu di Topbar
    menuBtn.addEventListener('click', function() {
        if (window.innerWidth < 1024) {
            // Mobile: Slide In/Out
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        } else {
            // Desktop: Toggle Kecil/Besar
            sidebar.classList.toggle('sidebar-collapsed');
            
            // Simpan status ke memori browser
            const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
            
            // Sinkronkan posisi Topbar
            syncTopbar();
        }
    });

    // Cek status tersimpan saat halaman dimuat
    if (window.innerWidth >= 1024) {
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            sidebar.classList.add('sidebar-collapsed');
        }
        syncTopbar();
    }

    // Jalankan sinkronisasi saat layar di-resize (misal dari desktop ke tablet)
    window.addEventListener('resize', syncTopbar);
});
</script>
