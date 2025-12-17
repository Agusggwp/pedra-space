<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuntungan - POS</title>
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
        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50 mt-20">
            <div class="max-w-7xl mx-auto">
                <!-- HEADER -->
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-4 rounded-xl">
                            <i class="ph ph-currency-circle-dollar text-4xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Laporan Keuntungan</h1>
                            <p class="text-gray-600">Analisis keuntungan penjualan per bulan</p>
                        </div>
                    </div>
                </div>

                <!-- FILTER SECTION -->
                <div class="bg-white p-6 rounded-2xl shadow-xl mb-8">
                    <form method="GET" action="{{ route('laporan.keuntungan') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Filter Tahun -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="ph ph-calendar mr-2"></i>Pilih Tahun
                                </label>
                                <select name="tahun" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    @for($y = 2020; $y <= now()->year; $y++)
                                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Filter Bulan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="ph ph-calendar mr-2"></i>Pilih Bulan
                                </label>
                                <select name="bulan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $nama)
                                        <option value="{{ $index + 1 }}" {{ $bulan == ($index + 1) ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="flex items-center gap-2 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-150 font-medium">
                                <i class="ph ph-magnifying-glass"></i>Tampilkan
                            </button>
                            <a href="{{ route('laporan.keuntungan') }}" class="flex items-center gap-2 px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-colors duration-150 font-medium">
                                <i class="ph ph-x"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- SUMMARY CARDS -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                    <!-- Total Penjualan -->
                    <div class="group bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-blue-500 transform hover:-translate-y-2">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                    <i class="ph ph-shopping-cart text-blue-600"></i>Total Penjualan
                                </p>
                                <p class="text-2xl md:text-3xl font-bold text-blue-600">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <i class="ph ph-shopping-cart text-3xl text-blue-600"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Total nilai penjualan (semua transaksi)</p>
                    </div>

                    <!-- Total Diskon -->
                    <div class="group bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-red-500 transform hover:-translate-y-2">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                    <i class="ph ph-tag text-red-600"></i>Total Diskon
                                </p>
                                <p class="text-2xl md:text-3xl font-bold text-red-600">Rp {{ number_format($totalDiskon, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-red-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <i class="ph ph-tag text-3xl text-red-600"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Total diskon yang diberikan</p>
                    </div>

                    <!-- Total Harga Beli -->
                    <div class="group bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-orange-500 transform hover:-translate-y-2">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                    <i class="ph ph-package text-orange-600"></i>Total Modal (Harga Beli)
                                </p>
                                <p class="text-2xl md:text-3xl font-bold text-orange-600">Rp {{ number_format($totalHargaBeli, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-orange-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <i class="ph ph-package text-3xl text-orange-600"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Total modal (harga beli)</p>
                    </div>

                    <!-- Total Keuntungan -->
                    <div class="group bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-green-500 transform hover:-translate-y-2">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                    <i class="ph ph-trend-up text-green-600"></i>Total Keuntungan
                                </p>
                                <p class="text-2xl md:text-3xl font-bold text-green-600">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <i class="ph ph-trend-up text-3xl text-green-600"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Selisih penjualan & modal</p>
                    </div>

                    <!-- Margin Keuntungan -->
                    <div class="group bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-l-4 border-purple-500 transform hover:-translate-y-2">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <p class="text-gray-500 text-sm font-medium mb-2 flex items-center gap-2">
                                    <i class="ph ph-percent text-purple-600"></i>Margin
                                </p>
                                <p class="text-2xl md:text-3xl font-bold text-purple-600">{{ $totalPenjualan > 0 ? number_format(($totalKeuntungan / $totalPenjualan) * 100, 2) : 0 }}%</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <i class="ph ph-percent text-3xl text-purple-600"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Persentase keuntungan</p>
                    </div>
                </div>

                <!-- EXPORT BUTTON -->
                <div class="mb-8 flex gap-3">
                    <a href="{{ route('laporan.keuntungan.pdf', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-150 font-medium shadow-lg">
                        <i class="ph ph-file-pdf"></i>Export PDF
                    </a>
                    <a href="{{ route('laporan.keuntungan.excel', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-150 font-medium shadow-lg">
                        <i class="ph ph-file-xls"></i>Export Excel
                    </a>
                </div>

                <!-- GRAFIK KEUNTUNGAN HARIAN -->
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-2xl mb-10 border-t-4 border-green-600">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-200">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-4 rounded-xl">
                            <i class="ph ph-chart-line text-4xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-800">Grafik Keuntungan Harian</h3>
                            <p class="text-gray-500 text-sm">Keuntungan per hari dalam bulan {{ ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$bulan] }} {{ $tahun }}</p>
                        </div>
                    </div>
                    <div class="h-80 md:h-96 lg:h-[500px]">
                        <canvas id="profitChart"></canvas>
                    </div>
                </div>

                <!-- DETAIL TABEL PRODUK -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 text-white px-6 py-4">
                        <h3 class="text-2xl font-bold flex items-center gap-3">
                            <i class="ph ph-list text-3xl"></i>
                            Detail Keuntungan per Item (Produk & Menu)
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        @if($keuntungan->count() > 0)
                            <table class="w-full">
                                <thead class="bg-gray-100 border-b-2 border-gray-300">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">#</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tipe</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama Item</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Qty</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Harga Beli</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Harga Jual</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Diskon</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Total Beli</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Total Jual</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Keuntungan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($keuntungan->groupBy(function($item) { return ($item->tipe ?? 'produk') . '_' . ($item->produk_id ?? $item->menu_id); }) as $items)
                                        @php
                                            $first = $items->first();
                                            $totalQty = $items->sum(function($item) { return $item->jumlah ?? $item->qty ?? 0; });
                                            
                                            // Hitung Total Jual ORIGINAL (sebelum diskon)
                                            $totalJualOriginal = $items->sum(function($item) { 
                                                $hargaAwal = $item->harga_awal ?? $item->harga_satuan ?? 0;
                                                $jumlah = $item->jumlah ?? $item->qty ?? 0;
                                                return $hargaAwal * $jumlah; 
                                            });
                                            
                                            // Hitung Total Diskon
                                            $totalDiskonItem = $items->sum(function($item) { 
                                                return ($item->diskon_nominal ?? 0) * ($item->jumlah ?? $item->qty ?? 0);
                                            });
                                            
                                            // Total Jual AKHIR (setelah diskon)
                                            $totalJual = $totalJualOriginal - $totalDiskonItem;
                                            
                                            if ($first->tipe === 'produk') {
                                                $totalBeli = $items->sum(function($item) { 
                                                    $hargaBeli = $item->produk->harga_beli ?? 0;
                                                    $jumlah = $item->jumlah ?? $item->qty ?? 0;
                                                    return $hargaBeli * $jumlah;
                                                });
                                                $namaItem = $first->produk->nama ?? 'N/A';
                                                $hargaBeli = $first->produk->harga_beli ?? 0;
                                            } else {
                                                $totalBeli = $items->sum(function($item) { 
                                                    $hargaBeli = $item->menu->harga_beli ?? 0;
                                                    $jumlah = $item->jumlah ?? $item->qty ?? 0;
                                                    return $hargaBeli * $jumlah;
                                                });
                                                $namaItem = $first->menu->nama ?? 'N/A';
                                                $hargaBeli = $first->menu->harga_beli ?? 0;
                                            }
                                            
                                            $totalKeuntunganItem = $totalJual - $totalBeli;
                                            $hargaSatuanDisplay = $first->harga_satuan ?? $first->harga ?? 0;
                                            $hargaAwalDisplay = $first->harga_awal ?? $hargaSatuanDisplay;
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 text-sm font-medium">
                                                @if($first->tipe === 'menu')
                                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">Menu</span>
                                                @else
                                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Produk</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $namaItem }}</td>
                                            <td class="px-6 py-4 text-sm text-right text-gray-700">{{ $totalQty }}</td>
                                            <td class="px-6 py-4 text-sm text-right text-gray-700">
                                                @if($hargaBeli > 0)
                                                    Rp {{ number_format($hargaBeli, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-right text-gray-700">Rp {{ number_format($hargaAwalDisplay, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-sm text-right text-red-600 font-medium">
                                                @php
                                                    $totalDiskonItem = $items->sum(function($item) { 
                                                        return ($item->diskon_nominal ?? 0) * ($item->jumlah ?? $item->qty ?? 0);
                                                    });
                                                @endphp
                                                @if($totalDiskonItem > 0)
                                                    -Rp {{ number_format($totalDiskonItem, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-right font-medium text-gray-900">Rp {{ number_format($totalBeli, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-sm text-right font-medium text-gray-900">Rp {{ number_format($totalJual, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-sm text-right font-bold {{ $first->tipe === 'menu' ? 'text-purple-600' : 'text-green-600' }}">Rp {{ number_format($totalKeuntunganItem, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="px-6 py-12 text-center text-gray-500">
                                <i class="ph ph-info text-5xl inline-block mb-3"></i>
                                <p class="text-lg">Tidak ada data keuntungan untuk periode ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const data = @json($hariData);

    const labels = data.map(item => {
        const d = new Date(item.tanggal);
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });

    const values = data.map(item => item.keuntungan);

    new Chart(document.getElementById('profitChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Keuntungan Harian',
                data: values,
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#059669',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#059669',
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
                        label: ctx => 'Keuntungan: Rp ' + ctx.parsed.y.toLocaleString('id-ID')
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
