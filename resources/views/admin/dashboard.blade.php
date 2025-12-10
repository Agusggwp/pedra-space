<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .ph { font-family: 'Phosphor'; }
        /* Pastikan header fixed dan tidak ikut scroll */
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
        }
        /* Konten utama mulai dari bawah header */
        .main-content {
            margin-top: 70px; /* Sesuaikan dengan tinggi header */
        }
        @media (min-width: 768px) {
            .main-content {
                margin-top: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar"
           class="fixed md:static inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200 p-6 flex flex-col justify-between transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
        <div>
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-white">POS ADMIN</h2>
                <hr class="border-gray-600 my-4">
                <p class="text-gray-300 text-lg">{{ auth()->user()->name }}</p>
                <p class="text-sm text-yellow-400">{{ ucfirst(auth()->user()->role) }}</p>
            </div>

            <nav class="space-y-3">
                @php $current = request()->path(); @endphp

                <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ $current == 'admin/dashboard' ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-house text-2xl"></i> Dashboard
                </a>
                <a href="{{ url('/admin/users') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'users') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-users text-2xl"></i> Manajemen User
                </a>
                <a href="{{ url('/admin/produk') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'produk') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-package text-2xl"></i> Produk
                </a>
                <a href="{{ url('/admin/stok') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'stok') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-chart-bar text-2xl"></i> Stok
                </a>
                <a href="{{ url('/admin/void') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'void') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-arrow-counter-clockwise text-2xl"></i> Void
                </a>
                <a href="{{ url('/admin/laporan') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'laporan') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-chart-line-up text-2xl"></i> Laporan
                </a>
            </nav>
        </div>

        <form action="{{ url('/logout') }}" method="POST" class="mt-8">
            @csrf
            <button class="flex items-center gap-4 px-5 py-4 rounded-xl w-full text-left text-red-400 hover:bg-red-600 hover:text-white text-lg transition">
                <i class="ph ph-sign-out text-2xl"></i> Logout
            </button>
        </form>
    </aside>

    <!-- OVERLAY -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-60 z-40 md:hidden hidden"></div>

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- HEADER FIXED (hanya muncul di mobile & tablet) -->
        <header class="fixed-header bg-white shadow-lg px-6 py-4 flex items-center justify-between md:hidden">
            <button id="menuBtn" class="text-3xl text-gray-800 hover:text-blue-600 transition">
                <i class="ph ph-list"></i>
            </button>
            <h1 class="text-xl font-bold text-blue-700">Dashboard</h1>
            <div class="w-10"></div>
        </header>

        <!-- MAIN CONTENT (dengan margin atas agar tidak tertutup header) -->
        <main class="main-content flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto">

            <h2 class="text-3xl md:text-4xl font-bold text-blue-700 mb-8 flex items-center gap-4">
                <i class="ph ph-speedometer text-5xl md:text-6xl"></i>
                Dashboard Utama
            </h2>

            <!-- 8 KARTU STATISTIK -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Kartu-kartu sama seperti sebelumnya -->
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border-l-8 border-green-500 hover:shadow-2xl transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600 text-sm md:text-base">Penjualan Hari Ini</p>
                            <p class="text-2xl md:text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($penjualanHariIni) }}</p>
                        </div>
                        <i class="ph ph-money text-6xl text-green-500 opacity-20"></i>
                    </div>
                </div>
               <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Transaksi Hari Ini</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $transaksiHariIni }}</p>
                    </div>
                    <i class="ph ph-receipt text-5xl text-blue-500 opacity-20"></i>
                </div>
            </div>

            <!-- 3. Stok Kritis -->
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Stok Kritis (≤ 10)</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stokKritis }}</p>
                    </div>
                    <i class="ph ph-warning text-5xl text-yellow-500 opacity-20"></i>
                </div>
            </div>

            <!-- 4. Kasir Aktif -->
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Kasir Aktif</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $kasirAktif }}</p>
                    </div>
                    <i class="ph ph-user-focus text-5xl text-purple-500 opacity-20"></i>
                </div>
            </div>

            <!-- 5. Total Produk -->
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Produk</p>
                        <p class="text-3xl font-bold text-indigo-600">{{ $totalProduk }}</p>
                    </div>
                    <i class="ph ph-cube text-5xl text-indigo-500 opacity-20"></i>
                </div>
            </div>

            <!-- 6. Transaksi Void Hari Ini -->
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Transaksi Dibatalkan</p>
                        <p class="text-3xl font-bold text-red-600">{{ $voidHariIni }}</p>
                    </div>
                    <i class="ph ph-x-circle text-5xl text-red-500 opacity-20"></i>
                </div>
            </div>

            <!-- 7. Penjualan Bulan Ini -->
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition border-l-4 border-teal-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Penjualan Bulan Ini</p>
                        <p class="text-3xl font-bold text-teal-600">Rp {{ number_format($penjualanBulanIni) }}</p>
                    </div>
                    <i class="ph ph-trend-up text-5xl text-teal-500 opacity-20"></i>
                </div>
            </div>

            <!-- 8. Shift Kasir Hari Ini -->
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Shift Kasir Hari Ini</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $shiftHariIni }}</p>
                    </div>
                    <i class="ph ph-clock-countdown text-5xl text-orange-500 opacity-20"></i>
                </div>
            </div>
            </div>

            <!-- GRAFIK -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl mt-10">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 flex items-center gap-4">
                    <i class="ph ph-trend-up text-4xl text-teal-600"></i>
                    Grafik Penjualan 30 Hari Terakhir
                </h3>
                <div class="h-80 md:h-96 lg:h-[500px]">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="mt-10 bg-gradient-to-r from-blue-600 to-purple-600 text-white p-8 rounded-2xl shadow-2xl">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <i class="ph ph-info text-5xl md:text-6xl"></i>
                    <div class="text-center md:text-left">
                        <h4 class="text-2xl md:text-3xl font-bold">Selamat Datang kembali, {{ auth()->user()->name }}!</h4>
                        <p class="text-lg md:text-xl mt-2">Kelola toko dengan mudah dari tablet atau desktop.</p>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- SCRIPT HAMBURGER MENU -->
<script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
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
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderWidth: 4,
                pointBackgroundColor: '#10b981',
                pointRadius: 6,
                pointHoverRadius: 10,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } }
            }
        }
    });
});
</script>

</body>
</html>