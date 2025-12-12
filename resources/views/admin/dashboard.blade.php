<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">

    <!-- SIDEBAR COMPONENT -->
    @include('components.sidebar')

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-hidden">

        <!-- TOPBAR COMPONENT -->
        @include('components.topbar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50">

            <!-- 8 KARTU STATISTIK dengan Desain Modern -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 mt-20">
                
                <!-- 1. Penjualan Hari Ini -->
                <div class="group bg-white p-6 md:p-7 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-green-500 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                <i class="ph ph-trend-up text-green-600"></i>
                                Penjualan Hari Ini
                            </p>
                            <p class="text-2xl md:text-3xl font-bold text-green-600">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                            <i class="ph ph-money text-3xl text-green-600"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="ph ph-calendar"></i>
                        <span>{{ now()->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- 2. Transaksi Hari Ini -->
                <div class="group bg-white p-6 md:p-7 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-blue-500 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                <i class="ph ph-receipt text-blue-600"></i>
                                Transaksi Hari Ini
                            </p>
                            <p class="text-2xl md:text-3xl font-bold text-blue-600">{{ $transaksiHariIni }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                            <i class="ph ph-receipt text-3xl text-blue-600"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="ph ph-clock"></i>
                        <span>Real-time</span>
                    </div>
                </div>

                <!-- 3. Stok Kritis -->
                <div class="group bg-white p-6 md:p-7 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-yellow-500 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                <i class="ph ph-warning text-yellow-600"></i>
                                Stok Kritis (≤ 10)
                            </p>
                            <p class="text-2xl md:text-3xl font-bold text-yellow-600">{{ $stokKritis }}</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                            <i class="ph ph-warning text-3xl text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="ph ph-package"></i>
                        <span>Perlu restock</span>
                    </div>
                </div>

                <!-- 4. Kasir Aktif -->
                <div class="group bg-white p-6 md:p-7 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-purple-500 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                <i class="ph ph-user-focus text-purple-600"></i>
                                Kasir Aktif
                            </p>
                            <p class="text-2xl md:text-3xl font-bold text-purple-600">{{ $kasirAktif }}</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                            <i class="ph ph-user-focus text-3xl text-purple-600"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="ph ph-users"></i>
                        <span>Sedang bertugas</span>
                    </div>
                </div>

                <!-- 5. Total Produk -->
                <div class="group bg-white p-6 md:p-7 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-indigo-500 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                <i class="ph ph-cube text-indigo-600"></i>
                                Total Produk
                            </p>
                            <p class="text-2xl md:text-3xl font-bold text-indigo-600">{{ $totalProduk }}</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                            <i class="ph ph-cube text-3xl text-indigo-600"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="ph ph-list-bullets"></i>
                        <span>Katalog produk</span>
                    </div>
                </div>

                <!-- 6. Total Uang (dari saldo_akhir semua shift) -->
                <div class="group bg-white p-6 md:p-7 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-emerald-500 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                <i class="ph ph-wallet text-emerald-600"></i>
                                Total Uang
                            </p>
                            <p class="text-2xl md:text-3xl font-bold text-emerald-600">Rp {{ number_format($totalUang, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-emerald-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                            <i class="ph ph-wallet text-3xl text-emerald-600"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="ph ph-currency-circle-dollar"></i>
                        <span>Jumlah saldo akhir (semua shift)</span>
                    </div>
                </div>

                <!-- 6. Transaksi Void -->
                <div class="group bg-white p-6 md:p-7 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-red-500 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                <i class="ph ph-x-circle text-red-600"></i>
                                Transaksi Dibatalkan
                            </p>
                            <p class="text-2xl md:text-3xl font-bold text-red-600">{{ $voidHariIni }}</p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                            <i class="ph ph-x-circle text-3xl text-red-600"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="ph ph-prohibit"></i>
                        <span>Hari ini</span>
                    </div>
                </div>

                <!-- 7. Penjualan Bulan Ini -->
                <div class="group bg-white p-6 md:p-7 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-teal-500 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                <i class="ph ph-trend-up text-teal-600"></i>
                                Penjualan Bulan Ini
                            </p>
                            <p class="text-2xl md:text-3xl font-bold text-teal-600">Rp {{ number_format($penjualanBulanIni, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-teal-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                            <i class="ph ph-trend-up text-3xl text-teal-600"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="ph ph-calendar-blank"></i>
                        <span>{{ now()->format('F Y') }}</span>
                    </div>
                </div>

                <!-- 8. Shift Kasir Hari Ini -->
                <div class="group bg-white p-6 md:p-7 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-orange-500 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                <i class="ph ph-clock-countdown text-orange-600"></i>
                                Shift Kasir Hari Ini
                            </p>
                            <p class="text-2xl md:text-3xl font-bold text-orange-600">{{ $shiftHariIni }}</p>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                            <i class="ph ph-clock-countdown text-3xl text-orange-600"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="ph ph-users-three"></i>
                        <span>Total shift</span>
                    </div>
                </div>

            </div>

            <!-- GRAFIK dengan Desain Modern -->
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-2xl mb-10 border-t-4 border-gradient-to-r from-blue-600 to-purple-600">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-200">
                    <div class="bg-gradient-to-r from-teal-500 to-emerald-500 p-4 rounded-xl">
                        <i class="ph ph-chart-line text-4xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800">Grafik Penjualan</h3>
                        <p class="text-gray-500 text-sm">30 Hari Terakhir</p>
                    </div>
                </div>
                <div class="h-80 md:h-96 lg:h-[500px]">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- CHART.JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const data = @json($penjualan30Hari);

    const labels = data.map(item => {
        const d = new Date(item.tanggal);
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });

    const values = data.map(item => item.total);

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Penjualan',
                data: values,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#10b981',
                pointHoverBorderColor: '#fff',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: true,
                    labels: {
                        font: { size: 14, weight: 'bold' },
                        color: '#374151'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: ctx => 'Penjualan: Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { 
                        font: { size: 12 },
                        callback: v => 'Rp ' + v.toLocaleString('id-ID')
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>

</body>
</html>