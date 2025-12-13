<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Penjualan Hari Ini - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-50">

@include('kasir.partials.sidebar')

<!-- MAIN CONTENT -->
<div class="lg:ml-72 p-6 md:p-8">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2 flex items-center gap-3">
                        <i class="ph ph-receipt text-gray-700"></i> 
                        Daftar Penjualan
                    </h1>
                    <p class="text-gray-600">
                        Kasir: <span class="font-semibold text-gray-800">{{ auth()->user()->name }}</span> • 
                        <span class="text-gray-700">{{ now()->format('d F Y') }}</span>
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('kasir.pos') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-gray-700 rounded-lg shadow-sm hover:shadow-md hover:bg-gray-50 transition font-semibold border border-gray-200">
                        <i class="ph ph-arrow-left text-lg"></i> 
                        <span class="hidden sm:inline">Kembali ke POS</span>
                    </a>

                    <a href="{{ route('kasir.dashboard') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-800 text-white rounded-lg shadow-sm hover:shadow-md hover:bg-gray-900 transition font-semibold">
                        <i class="ph ph-gauge text-lg"></i> 
                        <span class="hidden sm:inline">Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- STATS SUMMARY -->
            @if($transaksis->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-shopping-cart text-2xl text-gray-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Transaksi</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $transaksis->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-package text-2xl text-gray-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Item</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $transaksis->sum(function($t) { return $t->details->count(); }) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-currency-circle-dollar text-2xl text-gray-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Pendapatan</p>
                            <p class="text-xl font-bold text-gray-800">Rp {{ number_format($transaksis->sum('total')) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- JIKA KOSONG -->
        @if($transaksis->count() == 0)
            <div class="bg-white border-2 border-gray-200 rounded-lg p-12 text-center shadow-sm">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="ph ph-receipt-x text-5xl text-gray-400"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Penjualan Hari Ini</h4>
                <p class="text-gray-600 mb-6">Silakan mulai transaksi di halaman POS untuk melihat data di sini.</p>
                <a href="{{ route('kasir.pos') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-900 transition shadow-sm">
                    <i class="ph ph-shopping-cart text-xl"></i>
                    <span>Mulai Transaksi</span>
                </a>
            </div>

        @else
        
        <!-- TABEL TRANSAKSI -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Waktu</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Meja</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Metode</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Jumlah Item</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Total</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach($transaksis as $i => $t)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-sm font-semibold text-gray-700">{{ $i + 1 }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-clock text-gray-400"></i>
                                    <span class="text-sm font-medium text-gray-700">{{ $t->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-800">{{ $t->nama_pelanggan ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-chair text-gray-400"></i>
                                    <span class="text-sm text-gray-700">{{ $t->nomor_meja ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($t->metode_pembayaran == 'Tunai')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                        <i class="ph ph-money"></i>
                                        Tunai
                                    </span>
                                @elseif($t->metode_pembayaran == 'Transfer')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                        <i class="ph ph-bank"></i>
                                        Transfer
                                    </span>
                                @elseif($t->metode_pembayaran == 'QRIS')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                        <i class="ph ph-qr-code"></i>
                                        QRIS
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                        {{ $t->metode_pembayaran }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-package text-gray-400"></i>
                                    <span class="text-sm text-gray-700">{{ $t->details->count() }} item</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-800">Rp {{ number_format($t->total) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('kasir.cetak', $t->id) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition text-sm font-semibold shadow-sm">
                                    <i class="ph ph-printer"></i> 
                                    <span>Cetak</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="bg-gray-100 border-t-2 border-gray-300">
                            <th colspan="6" class="px-6 py-5 text-right text-base font-bold text-gray-800">
                                <i class="ph ph-calculator mr-2"></i>
                                TOTAL HARI INI
                            </th>
                            <th colspan="2" class="px-6 py-5 text-left text-xl font-bold text-gray-800">
                                Rp {{ number_format($transaksis->sum('total')) }}
                            </th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>

        @endif

    </div>
</div>

</body>
</html>