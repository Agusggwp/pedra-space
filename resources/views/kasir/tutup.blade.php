<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tutup Kasir - Sistem POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen">

    @include('components.topbar')
    <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-hidden pt-16">
            @include('kasir.partials.sidebar')

            <!-- MAIN CONTENT -->
            <div id="mainContent" class="main-content p-6 md:p-8">
                <div class="max-w-3xl mx-auto">

                    <!-- HEADER -->
                    <div class="mb-6">
                        
                        <!-- TITLE SECTION -->
                        <div class="flex items-start gap-4">
                            <!-- ICON LOCK -->
                            <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="ph-fill ph-lock text-2xl text-white"></i>
                            </div>
                            
                            <!-- TEXT -->
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-1">Tutup Kasir Hari Ini</h1>
                                <p class="text-sm text-gray-600">Kasir: <span class="font-semibold text-gray-900">{{ auth()->user()->name }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- CARD RINGKASAN -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 md:p-6 mb-5">
                        
                        <!-- RINGKASAN HEADER -->
                        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-200">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="ph ph-chart-bar text-xl text-gray-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-800">Ringkasan Shift</h2>
                                <p class="text-xs text-gray-600">Detail penjualan hari ini</p>
                            </div>
                        </div>

                        <!-- TABEL RINGKASAN -->
                        <div class="space-y-2">
                            
                            <!-- SALDO AWAL -->
                            <div class="flex justify-between items-center p-2.5 bg-gray-50 rounded-lg">
                                <span class="text-sm font-semibold text-gray-700">Saldo Awal</span>
                                <span class="text-sm font-bold text-gray-800">Rp {{ number_format($shift->saldo_awal) }}</span>
                            </div>

                            <!-- DIVIDER -->
                            <div class="border-t border-gray-200 my-3"></div>
                            <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2 mb-2">
                                <i class="ph ph-receipt"></i>
                                Rincian Penjualan per Metode
                            </h3>

                            <!-- TUNAI -->
                            <div class="flex justify-between items-center p-2.5 bg-white border border-gray-200 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-money text-lg text-gray-600"></i>
                                    <span class="text-sm font-medium text-gray-700">Penjualan Tunai</span>
                                </div>
                                <span class="text-sm font-bold text-gray-800">Rp {{ number_format($transaksiTunai) }}</span>
                            </div>

                            <!-- EDC -->
                            <div class="flex justify-between items-center p-2.5 bg-white border border-gray-200 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-credit-card text-lg text-gray-600"></i>
                                    <span class="text-sm font-medium text-gray-700">Penjualan EDC (Kartu)</span>
                                </div>
                                <span class="text-sm font-bold text-gray-800">Rp {{ number_format($transaksiEDC) }}</span>
                            </div>

                            <!-- QRIS -->
                            <div class="flex justify-between items-center p-2.5 bg-white border border-gray-200 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-qr-code text-lg text-gray-600"></i>
                                    <span class="text-sm font-medium text-gray-700">Penjualan QRIS</span>
                                </div>
                                <span class="text-sm font-bold text-gray-800">Rp {{ number_format($transaksiQRIS) }}</span>
                            </div>

                            <!-- TRANSFER -->
                            <div class="flex justify-between items-center p-2.5 bg-white border border-gray-200 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-bank text-lg text-gray-600"></i>
                                    <span class="text-sm font-medium text-gray-700">Penjualan Transfer</span>
                                </div>
                                <span class="text-sm font-bold text-gray-800">Rp {{ number_format($transaksiTransfer) }}</span>
                            </div>

                            <!-- TOTAL PENJUALAN -->
                            <div class="flex justify-between items-center p-3 bg-blue-50 border-2 border-blue-200 rounded-lg mt-3">
                                <span class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                    <i class="ph ph-currency-circle-dollar text-xl text-blue-600"></i>
                                    Total Penjualan (Semua Metode)
                                </span>
                                <span class="text-base font-bold text-blue-600">
                                    Rp {{ number_format($transaksiTunai + $transaksiEDC + $transaksiQRIS + $transaksiTransfer) }}
                                </span>
                            </div>

                            <!-- UANG YANG HARUS DISETORKAN -->
                            <div class="flex justify-between items-center p-3 bg-green-50 border-2 border-green-200 rounded-lg">
                                <span class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                    <i class="ph ph-calculator text-xl text-green-600"></i>
                                    Uang yang Harus Disetorkan
                                </span>
                                <span class="text-base font-bold text-green-600">
                                    Rp {{ number_format($shift->saldo_awal + $transaksiTunai + $transaksiEDC + $transaksiQRIS + $transaksiTransfer) }}
                                </span>
                            </div>

                            <p class="text-xs text-gray-600 italic mt-3">
                                * Saldo Awal + Semua Penjualan = Total uang yang harus disetorkan kepada pimpinan
                            </p>

                        </div>
                    </div>

                    <!-- FORM TUTUP KASIR -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 md:p-6">
                        <form action="{{ route('kasir.tutup') }}" method="POST">
                            @csrf

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Masukkan Total Uang dari Semua Transaksi <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                    name="saldo_akhir" 
                                    class="w-full px-4 py-3 text-right text-xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent" 
                                    step="100" 
                                    min="0" 
                                    placeholder="0" 
                                    required>
                                <p class="text-xs text-gray-600 mt-2">
                                    <i class="ph ph-info mr-1"></i>
                                    Masukkan total uang tunai yang diterima dari semua transaksi penjualan
                                </p>
                            </div>

                            <!-- INFO BOX -->
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mb-5 rounded-lg">
                                <div class="flex items-start gap-2">
                                    <i class="ph ph-warning text-xl text-yellow-600 flex-shrink-0 mt-0.5"></i>
                                    <div class="text-xs text-yellow-800">
                                        <p class="font-semibold mb-1">Perhatian!</p>
                                        <p>Setelah kasir ditutup, Anda tidak dapat melakukan transaksi lagi sampai membuka kasir di shift berikutnya. Pastikan semua transaksi sudah selesai.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- BUTTONS -->
                            <div class="space-y-2">
                                <button type="submit" 
                                        class="w-full px-5 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-bold shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-sm">
                                    <i class="ph ph-lock text-lg"></i>
                                    <span>TUTUP KASIR & HITUNG SELISIH</span>
                                </button>
                            </div>

                        </form>
                    </div>

                    <!-- FOOTER INFO -->
                    <div class="text-center mt-5 text-xs text-gray-500">
                        <p>Sistem akan otomatis menghitung selisih antara saldo akhir dengan harusnya ada</p>
                    </div>

                    @include('kasir.partials.footer')

                </div>
            </div>
        </div>
    </div>

<style>
/* Main content responsive ke sidebar */
.main-content {
    margin-left: 0;
    transition: margin-left 0.3s ease;
}

/* Desktop: sidebar expanded */
@media (min-width: 1024px) {
    .main-content {
        margin-left: 288px;
    }
    
    /* Desktop: sidebar collapsed */
    #sidebar.sidebar-collapsed ~ * .main-content,
    body:has(#sidebar.sidebar-collapsed) .main-content {
        margin-left: 72px;
    }
}

/* Mobile: no margin */
@media (max-width: 1023px) {
    .main-content {
        margin-left: 0 !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainContent = document.getElementById('mainContent');
    const sidebar = document.getElementById('sidebar');
    
    // Listen untuk perubahan sidebar
    window.addEventListener('sidebarToggle', function(e) {
        if (window.innerWidth >= 1024) {
            if (e.detail.collapsed) {
                mainContent.style.marginLeft = '72px';
            } else {
                mainContent.style.marginLeft = '288px';
            }
        }
    });
    
    // Set initial state berdasarkan localStorage
    if (window.innerWidth >= 1024) {
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            mainContent.style.marginLeft = '72px';
        } else {
            mainContent.style.marginLeft = '288px';
        }
    }
    
    // Handle resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            const isCollapsed = sidebar && sidebar.classList.contains('sidebar-collapsed');
            mainContent.style.marginLeft = isCollapsed ? '72px' : '288px';
        } else {
            mainContent.style.marginLeft = '0';
        }
    });
});
</script>

</body>
</html>