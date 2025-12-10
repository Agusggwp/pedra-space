<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
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

            <!-- Judul Halaman dengan Gradient Background -->
            <div class="mb-10 bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 rounded-3xl p-8 shadow-2xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center gap-6">
                    <div class="bg-white bg-opacity-20 backdrop-blur-lg p-5 rounded-2xl">
                        <i class="ph ph-chart-line-up text-6xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-2">
                            Laporan Penjualan
                        </h2>
                        <p class="text-white text-opacity-90 text-sm md:text-base">
                            Pantau dan analisis seluruh transaksi penjualan
                        </p>
                    </div>
                </div>
            </div>

            <!-- FILTER CARD dengan Desain Modern -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 mb-8 transform hover:shadow-3xl transition-all duration-300">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-purple-600 p-3 rounded-xl">
                        <i class="ph ph-funnel text-2xl text-white"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800">Filter Laporan</h4>
                </div>
                
                <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="ph ph-clock text-blue-600"></i>
                            Filter Waktu
                        </label>
                        <select name="filter" class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all bg-gray-50 hover:bg-white">
                            <option value="">Semua Waktu</option>
                            <option value="hari" {{ request('filter')=='hari' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="bulan" {{ request('filter')=='bulan' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="tahun" {{ request('filter')=='tahun' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="ph ph-calendar-check text-green-600"></i>
                            Dari Tanggal
                        </label>
                        <input type="date" name="from" value="{{ request('from') }}"
                               class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all bg-gray-50 hover:bg-white">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="ph ph-calendar-x text-red-600"></i>
                            Sampai Tanggal
                        </label>
                        <input type="date" name="to" value="{{ request('to') }}"
                               class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all bg-gray-50 hover:bg-white">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3.5 rounded-xl shadow-xl transition-all transform hover:scale-105 hover:shadow-2xl flex items-center justify-center gap-2">
                            <i class="ph ph-magnifying-glass text-xl"></i>
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- EXPORT BUTTONS dengan Desain Menarik -->
            <div class="flex flex-wrap gap-4 mb-6">
                <a href="{{ route('laporan.export.pdf', request()->query()) }}"
                   class="group bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white px-8 py-4 rounded-xl shadow-xl transition-all transform hover:scale-105 hover:shadow-2xl flex items-center gap-3 font-bold">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg group-hover:bg-opacity-30 transition-all">
                        <i class="ph ph-file-pdf text-2xl"></i>
                    </div>
                    <span>Export PDF</span>
                </a>
                <a href="{{ route('laporan.export.excel', request()->query()) }}"
                   class="group bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-8 py-4 rounded-xl shadow-xl transition-all transform hover:scale-105 hover:shadow-2xl flex items-center gap-3 font-bold">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg group-hover:bg-opacity-30 transition-all">
                        <i class="ph ph-file-xls text-2xl"></i>
                    </div>
                    <span>Export Excel</span>
                </a>
            </div>

           <!-- TABEL LAPORAN dengan Desain Modern & Menarik -->
<div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 p-6">
        <h3 class="text-2xl font-bold text-white flex items-center gap-3">
            <i class="ph ph-table text-3xl"></i>
            Data Transaksi
        </h3>
        <p class="text-white text-opacity-90 mt-1">Daftar lengkap transaksi penjualan</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-700 to-gray-900 text-white">
                <tr>
                    <th class="py-4 px-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="flex items-center gap-2">
                            <i class="ph ph-barcode"></i>
                            Kode
                        </div>
                    </th>
                    <th class="py-4 px-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="flex items-center gap-2">
                            <i class="ph ph-user"></i>
                            Kasir
                        </div>
                    </th>
                    <th class="py-4 px-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="flex items-center gap-2">
                            <i class="ph ph-money"></i>
                            Total
                        </div>
                    </th>
                    <th class="py-4 px-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="flex items-center gap-2">
                            <i class="ph ph-credit-card"></i>
                            Metode
                        </div>
                    </th>
                    <th class="py-4 px-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="flex items-center gap-2">
                            <i class="ph ph-check-circle"></i>
                            Status
                        </div>
                    </th>
                    <th class="py-4 px-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="flex items-center gap-2">
                            <i class="ph ph-calendar"></i>
                            Tanggal
                        </div>
                    </th>
                    <th class="py-4 px-4 text-center text-xs font-bold uppercase tracking-wider">
                        <div class="flex items-center justify-center gap-2">
                            <i class="ph ph-printer"></i>
                            Cetak
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($transaksi as $item)
                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 text-sm group">
                    <!-- KODE -->
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-2">
                            <div class="bg-blue-100 p-2 rounded-lg group-hover:bg-blue-200 transition-colors">
                                <i class="ph ph-hash text-blue-600"></i>
                            </div>
                            <span class="font-mono font-bold text-gray-800">
                                TRX-{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </td>

                    <!-- KASIR -->
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-2">
                            <div class="bg-purple-100 p-2 rounded-full group-hover:bg-purple-200 transition-colors">
                                <i class="ph ph-user-circle text-purple-600"></i>
                            </div>
                            <span class="font-medium text-gray-800 truncate max-w-32">
                                {{ $item->kasir->name ?? 'Tidak diketahui' }}
                            </span>
                        </div>
                    </td>

                    <!-- TOTAL -->
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-2">
                            <i class="ph ph-currency-circle-dollar text-green-600 text-lg"></i>
                            <span class="font-bold text-green-600 text-base">
                                Rp {{ number_format($item->total, 0, ',', '.') }}
                            </span>
                        </div>
                    </td>

                    <!-- METODE -->
                    <td class="py-4 px-4">
                        <span class="px-4 py-2 rounded-full text-xs font-bold bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-md inline-block">
                            {{ ucfirst($item->metode_pembayaran ?? '-') }}
                        </span>
                    </td>

                    <!-- STATUS -->
                    <td class="py-4 px-4">
                        @if($item->status == 'lunas')
                            <span class="px-4 py-2 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs font-bold shadow-md inline-flex items-center gap-1">
                                <i class="ph ph-check-circle"></i>
                                Lunas
                            </span>
                        @elseif($item->status == 'void')
                            <span class="px-4 py-2 rounded-full bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold shadow-md inline-flex items-center gap-1">
                                <i class="ph ph-x-circle"></i>
                                Void
                            </span>
                        @else
                            <span class="px-4 py-2 rounded-full bg-gradient-to-r from-gray-500 to-gray-600 text-white text-xs font-bold shadow-md">
                                Lainnya
                            </span>
                        @endif
                    </td>

                    <!-- TANGGAL -->
                    <td class="py-4 px-4">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2 text-gray-700">
                                <i class="ph ph-calendar-blank text-blue-600"></i>
                                <span class="font-medium">{{ $item->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-500 text-xs">
                                <i class="ph ph-clock text-purple-600"></i>
                                <span>{{ $item->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </td>

                    <!-- CETAK -->
                    <td class="py-4 px-4 text-center">
                        <a href="{{ route('kasir.cetak', $item->id) }}" target="_blank"
                           class="group inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-lg transition-all transform hover:scale-105 hover:shadow-xl">
                            <i class="ph ph-printer text-base"></i>
                            <span>Cetak</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-20">
                        <div class="text-gray-400">
                            <div class="bg-gradient-to-br from-gray-100 to-gray-200 w-32 h-32 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="ph ph-file-text text-8xl opacity-30"></i>
                            </div>
                            <p class="text-xl font-bold mb-2 text-gray-700">Tidak Ada Data Transaksi</p>
                            <p class="text-sm text-gray-500">Belum ada transaksi yang tercatat pada periode ini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

        </main>
    </div>
</div>

</body>
</html>