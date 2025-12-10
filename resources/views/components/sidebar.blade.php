<!-- SIDEBAR COMPONENT -->
<aside id="sidebar"
       class="fixed md:sticky inset-y-0 left-0 top-0 z-50 w-64 h-screen bg-gray-900 text-gray-300 p-4 flex flex-col transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out overflow-y-auto">
    <div class="flex-1 overflow-y-auto">
        <!-- HEADER SIDEBAR -->
        <div class="mb-8 pb-4 border-b border-gray-800">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                        <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/>
                        <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/>
                        <path d="M12 3v6"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-white font-bold text-lg">POS ADMIN</h2>
                    <p class="text-xs text-gray-500">Point of Sale</p>
                </div>
            </div>
            <div class="bg-gray-800 rounded-lg p-3">
                <p class="text-white text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
        </div>

        <!-- NAVIGATION MENU -->
        <nav class="space-y-1">
            @php $current = request()->path(); @endphp

            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 px-3">Menu</div>

            <a href="{{ url('/admin/dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ $current == 'admin/dashboard' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1"/>
                    <rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/>
                    <rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ url('/admin/users') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ str_contains($current,'users') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span>Manajemen User</span>
            </a>

            <a href="{{ url('/admin/produk') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ str_contains($current,'produk') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 16h3a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3"/>
                    <path d="M8 16H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3"/>
                    <path d="M12 3v18"/>
                </svg>
                <span>Produk</span>
            </a>

            <a href="{{ url('/admin/stok') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ str_contains($current,'stok') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" x2="12" y1="20" y2="10"/>
                    <line x1="18" x2="18" y1="20" y2="4"/>
                    <line x1="6" x2="6" y1="20" y2="16"/>
                </svg>
                <span>Manajemen Stok</span>
            </a>

            <a href="{{ url('/admin/void') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ str_contains($current,'void') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m4.9 4.9 14.2 14.2"/>
                </svg>
                <span>Void / Refund</span>
            </a>

            <a href="{{ url('/admin/laporan') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ str_contains($current,'laporan') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18"/>
                    <path d="m19 9-5 5-4-4-3 3"/>
                </svg>
                <span>Laporan Penjualan</span>
            </a>
        </nav>
    </div>

    <!-- LOGOUT BUTTON -->
    <div class="mt-4 pt-4 border-t border-gray-800 flex-shrink-0">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg w-full text-left text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" x2="9" y1="12" y2="12"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- OVERLAY untuk Mobile -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-60 z-40 md:hidden hidden"></div>

<!-- SCRIPT HAMBURGER MENU -->
<script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    // Tutup sidebar saat klik link
    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    });
</script>
