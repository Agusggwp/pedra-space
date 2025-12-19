<!-- SIDEBAR COMPONENT -->
<aside id="sidebar"
       class="fixed top-0 left-0 h-screen w-72 bg-gray-900 text-gray-300 flex flex-col transform -translate-x-full transition-all duration-300 ease-in-out lg:translate-x-0 z-50 shadow-2xl">
    
    <!-- HEADER SIDEBAR -->
    <div class="p-4 bg-gray-800 shrink-0 flex items-center overflow-hidden h-[73px]">
        <div id="sidebarLogo" class="flex gap-3 items-center justify-center min-w-0">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shrink-0 overflow-hidden p-1.5 shadow-sm">
                <img src="{{ asset('storage/logo/pedra.png') }}" alt="Pedra Logo" class="w-full h-full object-contain">
            </div>
            <div class="sidebar-labels whitespace-nowrap overflow-hidden transition-opacity duration-300">
                <h2 class="text-white font-bold text-base">Pedra Space</h2>
                <p class="text-[10px] text-gray-400 uppercase tracking-tighter">Coffee Shop</p>
            </div>
        </div>
    </div>

    <!-- NAVIGATION MENU -->
    <div class="flex-1 bg-gray-900 overflow-y-auto overflow-x-hidden py-6 px-3">
        <p class="sidebar-labels text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-4 px-3 whitespace-nowrap">
            MENU
        </p>

        <nav class="space-y-1.5">
            @php $current = request()->path(); @endphp

            <a href="{{ url('/admin/dashboard') }}" 
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-sm {{ $current == 'admin/dashboard' ? 'bg-blue-500 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <rect width="7" height="9" x="3" y="3" rx="1"/>
                    <rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/>
                    <rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                <span class="sidebar-labels whitespace-nowrap">Dashboard</span>
            </a>

           

            <a href="{{ url('/admin/users') }}" 
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-sm {{ str_contains($current,'users') ? 'bg-blue-500 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span class="sidebar-labels whitespace-nowrap">Manajemen User</span>
            </a>

             <a href="{{ route('admin.category.index') }}" 
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-sm {{ str_contains($current,'category') ? 'bg-blue-500 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                    <path d="M7 12a5 5 0 1 0 10 0 5 5 0 0 0-10 0z"/>
                </svg>
                <span class="sidebar-labels whitespace-nowrap">Kategori</span>
            </a>

            <a href="{{ url('/admin/produk') }}" 
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-sm {{ str_contains($current,'produk') ? 'bg-blue-500 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M16 16h3a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3"/>
                    <path d="M8 16H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3"/>
                    <path d="M12 3v18"/>
                </svg>
                <span class="sidebar-labels whitespace-nowrap">Produk</span>
            </a>

             <a href="{{ url('/admin/stok') }}" 
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-sm {{ str_contains($current,'stok') ? 'bg-blue-500 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <line x1="12" x2="12" y1="20" y2="10"/>
                    <line x1="18" x2="18" y1="20" y2="4"/>
                    <line x1="6" x2="6" y1="20" y2="16"/>
                </svg>
                <span class="sidebar-labels whitespace-nowrap">Manajemen Stok</span>
            </a>

            <a href="{{ route('admin.menu.index') }}" 
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-sm {{ str_contains($current,'menu') ? 'bg-blue-500 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M4 7h16"/>
                    <path d="M4 12h16"/>
                    <path d="M4 17h16"/>
                </svg>
                <span class="sidebar-labels whitespace-nowrap">Manajemen Menu</span>
            </a>

           

            <a href="{{ url('/admin/void') }}" 
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-sm {{ str_contains($current,'void') ? 'bg-blue-500 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m4.9 4.9 14.2 14.2"/>
                </svg>
                <span class="sidebar-labels whitespace-nowrap">Void / Refund</span>
            </a>

            <a href="{{ url('/admin/diskon') }}" 
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-sm {{ str_contains($current,'diskon') ? 'bg-blue-500 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <circle cx="20.5" cy="6.5" r="1.5"/>
                    <circle cx="3.5" cy="17.5" r="1.5"/>
                    <path d="M3 6.5h15m-13 11h13"/>
                </svg>
                <span class="sidebar-labels whitespace-nowrap">Set Diskon</span>
            </a>

            <!-- Laporan Penjualan with Submenu -->
            <div class="group">
                <button class="flex items-center gap-3 px-3 py-3 rounded-lg text-sm w-full {{ str_contains($current,'laporan') ? 'bg-blue-500 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150" onclick="toggleSubmenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                        <path d="M3 3v18h18"/>
                        <path d="m19 9-5 5-4-4-3 3"/>
                    </svg>
                    <span class="sidebar-labels whitespace-nowrap">Laporan Penjualan</span>
                    <svg class="ml-auto w-4 h-4 transition-transform duration-300 sidebar-labels" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                
                <!-- Submenu -->
                <div class="submenu hidden pl-4 space-y-1 mt-1 sidebar-labels">
                    <a href="{{ url('/admin/laporan') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $current == 'admin/laporan' ? 'bg-blue-600 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                            <path d="M12 6v6l4 2.4"/>
                        </svg>
                        <span class="sidebar-labels whitespace-nowrap">Laporan Umum</span>
                    </a>
                    
                    <a href="{{ url('/admin/laporan-shift') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ str_contains($current,'laporan-shift') ? 'bg-blue-600 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        <span class="sidebar-labels whitespace-nowrap">Laporan Per Shift User</span>
                    </a>

                    <a href="{{ url('/admin/laporan-keuntungan') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ str_contains($current,'laporan-keuntungan') ? 'bg-blue-600 text-white font-medium' : 'text-gray-400 hover:text-white font-normal' }} transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                            <line x1="12" x2="12" y1="20" y2="10"/>
                            <line x1="18" x2="18" y1="20" y2="4"/>
                            <line x1="6" x2="6" y1="20" y2="16"/>
                        </svg>
                        <span class="sidebar-labels whitespace-nowrap">Laporan Keuntungan</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- LOGOUT BUTTON -->
    <div class="px-4 pb-6 pt-4 border-t border-gray-800 flex-shrink-0">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition-colors duration-150 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" x2="9" y1="12" y2="12"/>
                </svg>
                <span class="sidebar-labels whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- OVERLAY untuk Mobile -->
<div id="overlay" class="fixed inset-0 bg-black/50 z-30 lg:hidden hidden backdrop-blur-sm transition-opacity duration-300"></div>

<style>
/* Sidebar Transitions */
#sidebar {
    width: 288px;
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s ease-in-out;
}

/* Collapsed State Styles */
#sidebar.sidebar-collapsed {
    width: 85px !important;
}

#sidebar.sidebar-collapsed .sidebar-labels {
    opacity: 0;
    visibility: hidden;
    position: absolute;
}

#sidebar.sidebar-collapsed nav a, 
#sidebar.sidebar-collapsed nav div,
#sidebar.sidebar-collapsed nav button,
#sidebar.sidebar-collapsed button[type="submit"] {
    justify-content: center;
    padding-left: 0;
    padding-right: 0;
    gap: 0;
}

#sidebar.sidebar-collapsed #sidebarLogo {
    justify-content: center;
}

#sidebar.sidebar-collapsed .submenu {
    display: none !important;
}

/* Scrollbar Style */
#sidebar div::-webkit-scrollbar { width: 4px; }
#sidebar div::-webkit-scrollbar-track { background: transparent; }
#sidebar div::-webkit-scrollbar-thumb { background: #4b5563; border-radius: 10px; }
</style>

<!-- Submenu Toggle Script -->
<script>
function toggleSubmenu(event) {
    event.preventDefault();
    const submenu = event.target.closest('.group').querySelector('.submenu');
    const arrow = event.target.closest('button').querySelector('svg:last-child');
    
    submenu.classList.toggle('hidden');
    arrow.classList.toggle('rotate-180');
}
</script>
