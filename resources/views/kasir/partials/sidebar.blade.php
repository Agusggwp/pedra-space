<!-- SIDEBAR KASIR -->
<div id="sidebar" class="fixed top-0 left-0 h-screen w-80 sidebar-kasir text-white transform -translate-x-full transition-transform duration-300 lg:translate-x-0 z-50 flex flex-col overflow-hidden">
    
    <!-- Logo & User -->
    <div class="p-6 bg-gradient-to-br from-emerald-600 to-teal-700 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-emerald-600 text-xl font-bold shadow-xl flex-shrink-0">
                {{ Str::substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-lg font-bold text-white truncate">{{ auth()->user()->name }}</h3>
                <p class="text-emerald-100 text-xs font-medium whitespace-nowrap">👤 Kasir Aktif</p>
            </div>
        </div>
    </div>

    <!-- Menu Section -->
    <div class="flex-1 p-6 bg-gradient-to-b from-emerald-50 to-teal-50 flex-shrink-0 min-h-0">
        <!-- Menu Label -->
        <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-3 px-3 whitespace-nowrap">📋 Menu Kasir</p>

        <!-- Menu -->
        <nav class="space-y-2">
            <a href="{{ route('kasir.dashboard') }}" class="menu-item-kasir {{ request()->routeIs('kasir.dashboard') ? 'active-kasir' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all">
                <i class="ph ph-house text-2xl flex-shrink-0"></i>
                <span class="font-semibold text-sm whitespace-nowrap">Dashboard</span>
            </a>
            <a href="{{ route('kasir.pos') }}" class="menu-item-kasir {{ request()->routeIs('kasir.pos') ? 'active-kasir' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all">
                <i class="ph ph-shopping-cart text-2xl flex-shrink-0"></i>
                <span class="font-semibold text-sm whitespace-nowrap">Penjualan (POS)</span>
            </a>
            <a href="{{ route('kasir.daftar') }}" class="menu-item-kasir {{ request()->routeIs('kasir.daftar') ? 'active-kasir' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all">
                <i class="ph ph-receipt text-2xl flex-shrink-0"></i>
                <span class="font-semibold text-sm whitespace-nowrap">Daftar Penjualan</span>
            </a>
            <a href="{{ route('kasir.update-stok') }}" class="menu-item-kasir {{ request()->routeIs('kasir.update-stok') ? 'active-kasir' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all">
                <i class="ph ph-package text-2xl flex-shrink-0"></i>
                <span class="font-semibold text-sm whitespace-nowrap">Update Stok</span>
            </a>

            @php
                $shiftAktif = \App\Models\ShiftKasir::buka()->where('user_id', auth()->id())->first();
            @endphp

            @if($shiftAktif)
            <a href="{{ route('kasir.tutup.form') }}" class="menu-item-kasir {{ request()->routeIs('kasir.tutup.form') ? 'active-kasir' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all">
                <i class="ph ph-door text-2xl flex-shrink-0"></i>
                <span class="font-semibold text-sm whitespace-nowrap">Tutup Kasir</span>
            </a>
            @else
            <div class="menu-item-kasir flex items-center gap-3 px-4 py-3 rounded-xl opacity-40 cursor-not-allowed">
                <i class="ph ph-door text-2xl flex-shrink-0"></i>
                <span class="font-semibold text-sm whitespace-nowrap">Tutup Kasir</span>
            </div>
            @endif
        </nav>
    </div>

    <!-- LOGOUT BUTTON & FOOTER -->
    <div class="p-6 bg-gradient-to-br from-emerald-600 to-teal-700 flex-shrink-0">
        <form action="{{ url('/logout') }}" method="POST" class="mb-4">
            @csrf
            <button class="w-full flex items-center justify-center gap-3 px-5 py-3 rounded-xl bg-red-600 text-white hover:bg-red-700 transition font-bold shadow-xl hover:shadow-2xl transform hover:scale-105">
                <i class="ph ph-sign-out text-xl flex-shrink-0"></i>
                <span class="text-sm whitespace-nowrap">Logout</span>
            </button>
        </form>

        <!-- FOOTER ARTDEVATA -->
        <div class="text-center border-t border-emerald-400 pt-4">
            <p class="text-xs text-emerald-100 mb-1">Dibuat oleh</p>
            <a href="https://artdevata.net" target="_blank" class="text-base font-bold text-white hover:text-emerald-200 transition">
                ArtDevata
            </a>
            <p class="text-xs text-emerald-100 mt-1">artdevata.net • Bali</p>
        </div>
    </div>
</div>

<!-- TOGGLE SIDEBAR (Mobile) -->
<button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')"
        class="lg:hidden fixed top-6 left-6 bg-emerald-600 shadow-xl text-white p-4 rounded-2xl z-50 border-2 border-emerald-500 hover:bg-emerald-700 transition">
    <i class="ph ph-list text-2xl"></i>
</button>

<style>
.sidebar-kasir {
    width: 320px !important;
    max-width: 320px !important;
    min-width: 320px !important;
    box-shadow: 8px 0 30px rgba(16, 185, 129, 0.3);
}
@media (min-width: 1024px) {
    .sidebar-kasir {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        height: 100vh !important;
        transform: translateX(0) !important;
    }
}
.menu-item-kasir {
    color: #047857;
    background: white;
    border: 2px solid transparent;
}
.menu-item-kasir:hover {
    background: #d1fae5;
    border-color: #10b981;
    transform: translateX(4px);
}
.menu-item-kasir.active-kasir {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border-color: #047857;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}
</style>
