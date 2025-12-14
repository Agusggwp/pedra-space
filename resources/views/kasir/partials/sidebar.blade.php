<!-- SIDEBAR KASIR -->
<div id="sidebar" class="fixed top-0 left-0 h-screen w-72 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 lg:translate-x-0 z-50 flex flex-col">
    
    <!-- Logo & User -->
    <div class="p-4 bg-emerald-600 flex-shrink-0 flex justify-center items-center">
        <div class="flex gap-3 items-center">
            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden p-2">
                <img src="{{ asset('storage/logo/pedra.png') }}" alt="Pedra Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <h2 class="text-white font-bold text-base">Pedra Space</h2>
                <p class="text-xs text-gray-400">Coffee Shop</p>
            </div>
        </div>
    </div>

    <!-- Menu Section -->
    <div class="flex-1 p-6 bg-gray-50 overflow-y-auto">
        <!-- Menu Label -->
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 px-3">📋 Menu Kasir</p>

        <!-- Menu -->
        <nav class="space-y-2">
            <a href="{{ route('kasir.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('kasir.dashboard') ? 'bg-emerald-600 text-white border-emerald-700' : 'bg-white text-gray-700 hover:bg-gray-100 hover:border-emerald-300 border-transparent' }} border-2">
                <i class="ph ph-house text-xl flex-shrink-0"></i>
                <span class="font-semibold text-sm">Dashboard</span>
            </a>
            
            <a href="{{ route('kasir.pos') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('kasir.pos') ? 'bg-emerald-600 text-white border-emerald-700' : 'bg-white text-gray-700 hover:bg-gray-100 hover:border-emerald-300 border-transparent' }} border-2">
                <i class="ph ph-shopping-cart text-xl flex-shrink-0"></i>
                <span class="font-semibold text-sm">Penjualan (POS)</span>
            </a>
            
            <a href="{{ route('kasir.daftar') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('kasir.daftar') ? 'bg-emerald-600 text-white border-emerald-700' : 'bg-white text-gray-700 hover:bg-gray-100 hover:border-emerald-300 border-transparent' }} border-2">
                <i class="ph ph-receipt text-xl flex-shrink-0"></i>
                <span class="font-semibold text-sm">Daftar Penjualan</span>
            </a>
            
            <a href="{{ route('kasir.update-stok') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('kasir.update-stok') ? 'bg-emerald-600 text-white border-emerald-700' : 'bg-white text-gray-700 hover:bg-gray-100 hover:border-emerald-300 border-transparent' }} border-2">
                <i class="ph ph-package text-xl flex-shrink-0"></i>
                <span class="font-semibold text-sm">Update Stok</span>
            </a>

            @php
                $shiftAktif = \App\Models\ShiftKasir::buka()->where('user_id', auth()->id())->first();
            @endphp

            @if($shiftAktif)
            <a href="{{ route('kasir.tutup.form') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('kasir.tutup.form') ? 'bg-emerald-600 text-white border-emerald-700' : 'bg-white text-gray-700 hover:bg-gray-100 hover:border-emerald-300 border-transparent' }} border-2">
                <i class="ph ph-door text-xl flex-shrink-0"></i>
                <span class="font-semibold text-sm">Tutup Kasir</span>
            </a>
            @else
            <div class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white text-gray-400 border-2 border-transparent opacity-50 cursor-not-allowed">
                <i class="ph ph-door text-xl flex-shrink-0"></i>
                <span class="font-semibold text-sm">Tutup Kasir</span>
            </div>
            @endif
        </nav>
    </div>

    <!-- LOGOUT BUTTON & FOOTER -->
    <div class="p-6 bg-white flex-shrink-0 border-t border-gray-200">
        <form action="{{ url('/logout') }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-5 py-3 rounded-lg bg-red-600 text-white hover:bg-red-700 transition font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <i class="ph ph-sign-out text-lg flex-shrink-0"></i>
                <span class="text-sm">Logout</span>
            </button>
        </form>

        <!-- FOOTER ARTDEVATA (Optional - Uncomment if needed) -->
        <!-- <div class="text-center border-t border-gray-200 pt-4">
            <p class="text-xs text-gray-500 mb-1">Dibuat oleh</p>
            <a href="https://artdevata.net" target="_blank" class="text-base font-bold text-emerald-600 hover:text-emerald-700 transition">
                ArtDevata
            </a>
            <p class="text-xs text-gray-500 mt-1">artdevata.net • Bali</p>
        </div> -->
    </div>
</div>

<!-- TOGGLE SIDEBAR (Mobile) -->
<button id="sidebarToggle"
        class="lg:hidden fixed top-5 left-5 bg-emerald-600 text-white p-3 rounded-lg z-40 shadow-lg hover:bg-emerald-700 transition">
    <i class="ph ph-list text-2xl"></i>
</button>

<style>
/* Force consistent sidebar width - EXACTLY 288px (w-72) */
#sidebar {
    width: 288px !important;
    max-width: 288px !important;
    min-width: 288px !important;
}

/* Ensure sidebar stays fixed on desktop */
@media (min-width: 1024px) {
    #sidebar {
        transform: translateX(0) !important;
    }
    
    #sidebarBackdrop {
        display: none !important;
    }
}

/* Custom scrollbar for menu area */
#sidebar > div:nth-child(2)::-webkit-scrollbar {
    width: 6px;
}

#sidebar > div:nth-child(2)::-webkit-scrollbar-track {
    background: transparent;
}

#sidebar > div:nth-child(2)::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 3px;
}

#sidebar > div:nth-child(2)::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    // Toggle sidebar when clicking hamburger
    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        sidebar.classList.toggle('-translate-x-full');
    });
    
    // Close sidebar when clicking outside sidebar
    document.addEventListener('click', function(event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnToggle = toggleBtn.contains(event.target);
        const isSidebarOpen = !sidebar.classList.contains('-translate-x-full');
        
        if (isSidebarOpen && !isClickInsideSidebar && !isClickOnToggle) {
            sidebar.classList.add('-translate-x-full');
        }
    });
});
</script>