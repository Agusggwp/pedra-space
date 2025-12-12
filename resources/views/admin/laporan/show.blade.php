<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Shift #{{ $shift->id }} - POS</title>
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
        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50 mt-20">
            <div class="max-w-7xl mx-auto">
                <!-- HEADER -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('laporan.shift') }}" class="p-3 rounded-lg bg-gray-300 hover:bg-gray-400 transition-colors">
                                <i class="ph ph-arrow-left text-2xl text-white"></i>
                            </a>
                            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4 rounded-xl">
                                <i class="ph ph-calendar-check text-4xl text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Detail Shift #{{ $shift->id }}</h1>
                                <p class="text-gray-600">{{ $shift->user->name ?? 'N/A' }} - {{ $shift->dibuka_pada->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SHIFT INFO CARDS -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <!-- Kasir -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-blue-500">
                        <p class="text-gray-600 text-sm mb-2">Nama Kasir</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $shift->user->name ?? '-' }}</p>
                    </div>

                    <!-- Waktu Buka -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-green-500">
                        <p class="text-gray-600 text-sm mb-2">Dibuka Pada</p>
                        <p class="text-xl font-bold text-green-600">{{ $shift->dibuka_pada->format('d M Y') }}</p>
                        <p class="text-sm text-gray-500">{{ $shift->dibuka_pada->format('H:i') }}</p>
                    </div>

                    <!-- Waktu Tutup -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-orange-500">
                        <p class="text-gray-600 text-sm mb-2">Ditutup Pada</p>
                        <p class="text-xl font-bold text-orange-600">{{ $shift->ditutup_pada?->format('d M Y') ?? 'Belum' }}</p>
                        <p class="text-sm text-gray-500">{{ $shift->ditutup_pada?->format('H:i') ?? 'Ditutup' }}</p>
                    </div>

                    <!-- Status -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-purple-500">
                        <p class="text-gray-600 text-sm mb-2">Status Shift</p>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ $shift->status == 'buka' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            <i class="ph mr-2"></i>{{ ucfirst($shift->status) }}
                        </span>
                    </div>
                </div>

                <!-- SALDO CARDS -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-cyan-500">
                        <p class="text-gray-600 text-sm mb-2">Saldo Awal</p>
                        <p class="text-3xl font-bold text-cyan-600">Rp {{ number_format($shift->saldo_awal ?? 0, 0, ',', '.') }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-emerald-500">
                        <p class="text-gray-600 text-sm mb-2">Saldo Akhir</p>
                        <p class="text-3xl font-bold text-emerald-600">Rp {{ number_format($shift->saldo_akhir ?? 0, 0, ',', '.') }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 {{ ($shift->selisih ?? 0) >= 0 ? 'border-lime-500' : 'border-red-500' }}">
                        <p class="text-gray-600 text-sm mb-2">Selisih</p>
                        <p class="text-3xl font-bold {{ ($shift->selisih ?? 0) >= 0 ? 'text-lime-600' : 'text-red-600' }}">
                            Rp {{ number_format($shift->selisih ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- EXPORT BUTTONS -->
                <div class="flex gap-3 mb-8">
                    <a href="{{ route('laporan.shift.detail.pdf', $shift->id) }}" class="flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-150 font-medium shadow-lg">
                        <i class="ph ph-file-pdf"></i>Export PDF
                    </a>
                    <a href="{{ route('laporan.shift.detail.excel', $shift->id) }}" class="flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-150 font-medium shadow-lg">
                        <i class="ph ph-file-xls"></i>Export Excel
                    </a>
                </div>

                <!-- TRANSAKSI TABLE -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 text-white px-6 py-4">
                        <h3 class="text-2xl font-bold flex items-center gap-3">
                            <i class="ph ph-receipt text-3xl"></i>
                            Daftar Transaksi ({{ $transaksi->count() }} transaksi)
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        @if($transaksi->count() > 0)
                            <table class="w-full">
                                <thead class="bg-gray-100 border-b-2 border-gray-300">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">#</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">ID Transaksi</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Waktu</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Metode</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Total</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Bayar</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Kembalian</th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($transaksi as $item)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-blue-600">#{{ $item->id }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->created_at->format('d M Y H:i') }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($item->metode_pembayaran) }}</td>
                                            <td class="px-6 py-4 text-sm text-right font-medium text-gray-900">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-sm text-right font-medium text-gray-900">Rp {{ number_format($item->bayar, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-sm text-right font-medium text-gray-900">Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $item->status == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- SUMMARY SECTION -->
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-6 border-t-2 border-gray-300">
                                <h4 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Transaksi</h4>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <p class="text-gray-600 text-sm mb-1">Total Transaksi</p>
                                        <p class="text-2xl font-bold text-gray-800">{{ $transaksi->count() }}</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <p class="text-gray-600 text-sm mb-1">Total Lunas</p>
                                        <p class="text-2xl font-bold text-green-600">{{ $transaksi->where('status', 'lunas')->count() }}</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <p class="text-gray-600 text-sm mb-1">Total Void</p>
                                        <p class="text-2xl font-bold text-red-600">{{ $transaksi->where('status', 'void')->count() }}</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <p class="text-gray-600 text-sm mb-1">Total Nilai</p>
                                        <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($transaksi->where('status', 'lunas')->sum('total'), 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <p class="text-gray-600 text-sm mb-1">Total Diterima</p>
                                        <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($transaksi->sum('bayar'), 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <p class="text-gray-600 text-sm mb-1">Total Kembalian</p>
                                        <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($transaksi->sum('kembalian'), 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <p class="text-gray-600 text-sm mb-1">Selisih Transaksi</p>
                                        <p class="text-2xl font-bold {{ $transaksi->sum('bayar') - $transaksi->sum('total') >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            Rp {{ number_format($transaksi->sum('bayar') - $transaksi->sum('total'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="px-6 py-12 text-center text-gray-500">
                                <i class="ph ph-info text-5xl inline-block mb-3"></i>
                                <p class="text-lg">Tidak ada transaksi untuk shift ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>
