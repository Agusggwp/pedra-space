<!-- SIDEBAR -->
<div id="sidebar" class="fixed top-0 left-0 h-screen w-72 bg-white shadow-lg transform -translate-x-full transition-all duration-300 lg:translate-x-0 z-50 flex flex-col border-r border-gray-200">
    
    <div class="p-4 bg-emerald-600 shrink-0 flex items-center overflow-hidden h-[73px]">
        <div id="sidebarLogo" class="flex gap-3 items-center justify-center min-w-0">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shrink-0 overflow-hidden p-1.5 shadow-sm">
                <img src="{{ asset('storage/logo/pedra.png') }}" alt="P" class="w-full h-full object-contain">
            </div>
            <div class="sidebar-labels whitespace-nowrap overflow-hidden transition-opacity duration-300">
                <h2 class="text-white font-bold text-base">Pedra Space</h2>
                <p class="text-[10px] text-emerald-100 uppercase tracking-tighter">Coffee Shop</p>
            </div>
        </div>
    </div>

    <div class="flex-1 bg-gray-50 overflow-y-auto overflow-x-hidden py-6 px-3">
        <p class="sidebar-labels text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4 px-3 whitespace-nowrap">
            📋 Menu Kasir
        </p>

        <nav class="space-y-1.5">
            <a href="{{ route('kasir.dashboard') }}" 
               class="flex items-center gap-4 px-3 py-3 rounded-lg transition-all {{ request()->routeIs('kasir.dashboard') ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 border border-gray-100' }}">
                <i class="ph ph-house text-2xl shrink-0"></i>
                <span class="font-semibold text-sm sidebar-labels whitespace-nowrap">Dashboard</span>
            </a>
            
            <a href="{{ route('kasir.pos') }}" 
               class="flex items-center gap-4 px-3 py-3 rounded-lg transition-all {{ request()->routeIs('kasir.pos') ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 border border-gray-100' }}">
                <i class="ph ph-shopping-cart text-2xl shrink-0"></i>
                <span class="font-semibold text-sm sidebar-labels whitespace-nowrap">Penjualan (POS)</span>
            </a>
            
            <a href="{{ route('kasir.daftar') }}" 
               class="flex items-center gap-4 px-3 py-3 rounded-lg transition-all {{ request()->routeIs('kasir.daftar') ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 border border-gray-100' }}">
                <i class="ph ph-receipt text-2xl shrink-0"></i>
                <span class="font-semibold text-sm sidebar-labels whitespace-nowrap">Daftar Penjualan</span>
            </a>
            
            <a href="{{ route('kasir.update-stok') }}" 
               class="flex items-center gap-4 px-3 py-3 rounded-lg transition-all {{ request()->routeIs('kasir.update-stok') ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 border border-gray-100' }}">
                <i class="ph ph-package text-2xl shrink-0"></i>
                <span class="font-semibold text-sm sidebar-labels whitespace-nowrap">Update Stok</span>
            </a>

            @php
                $shiftAktif = \App\Models\ShiftKasir::buka()->where('user_id', auth()->id())->first();
            @endphp

            @if($shiftAktif)
            <a href="{{ route('kasir.tutup.form') }}" 
               class="flex items-center gap-4 px-3 py-3 rounded-lg transition-all {{ request()->routeIs('kasir.tutup.form') ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 border border-gray-100' }}">
                <i class="ph ph-door text-2xl shrink-0"></i>
                <span class="font-semibold text-sm sidebar-labels whitespace-nowrap">Tutup Kasir</span>
            </a>
            @else
            <div class="flex items-center gap-4 px-3 py-3 rounded-lg bg-gray-100 text-gray-400 border border-gray-200 opacity-60 cursor-not-allowed">
                <i class="ph ph-door text-2xl shrink-0"></i>
                <span class="font-semibold text-sm sidebar-labels whitespace-nowrap">Tutup Kasir</span>
            </div>
            @endif
        </nav>
    </div>

    <div class="p-4 bg-white shrink-0 border-t border-gray-100">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 px-3 py-3 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all font-bold group">
                <i class="ph ph-sign-out text-2xl shrink-0"></i>
                <span class="text-sm sidebar-labels whitespace-nowrap">Log Out</span>
            </button>
        </form>
    </div>
</div>

<!-- OVERLAY -->
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
#sidebar.sidebar-collapsed button[type="submit"] {
    justify-content: center;
    padding-left: 0;
    padding-right: 0;
    gap: 0;
}

#sidebar.sidebar-collapsed #sidebarLogo {
    justify-content: center;
}

/* Scrollbar Style */
#sidebar div::-webkit-scrollbar { width: 4px; }
#sidebar div::-webkit-scrollbar-track { background: transparent; }
#sidebar div::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
</style>