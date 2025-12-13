<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Penjualan Hari Ini - Kasir</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        body {
            background-color: #f5f5f5;
            color: #333;
            min-height: 100vh;
        }
    </style>
</head>
<body>

@include('kasir.partials.sidebar')

<!-- MAIN CONTENT -->
<div class="lg:ml-72 p-8">
    <div class="max-w-7xl mx-auto py-8">

        <!-- HEADER -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <i class="ph ph-receipt"></i> Daftar Penjualan Hari Ini
            </h1>

            <p class="text-gray-600 mb-6">
                Kasir: <strong>{{ auth()->user()->name }}</strong> |
                {{ now()->format('d F Y') }}
            </p>

            <div class="flex justify-center gap-3">
                <a href="{{ route('kasir.pos') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg shadow-md hover:bg-gray-50 hover:shadow-lg transition font-semibold border border-gray-200">
                    <i class="ph ph-arrow-left text-xl"></i> Kembali ke POS
                </a>

                <a href="{{ route('kasir.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gray-800 text-white rounded-lg shadow-md hover:bg-gray-900 hover:shadow-lg transition font-semibold">
                    <i class="ph ph-gauge text-xl"></i> Dashboard
                </a>
            </div>
        </div>

        <!-- JIKA KOSONG -->
        @if($transaksis->count() == 0)
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-8 text-center">
                <i class="ph ph-info text-5xl text-yellow-500 mb-4"></i>
                <h4 class="text-xl font-bold text-yellow-800 mb-2">Belum Ada Penjualan Hari Ini</h4>
                <p class="text-yellow-700">Silakan mulai transaksi di halaman POS.</p>
            </div>

        @else
        
        <!-- TABEL TRANSAKSI -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">No</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Waktu</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Meja</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Metode</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Jumlah Item</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Total</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach($transaksis as $i => $t)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $t->created_at->format('H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $t->nama_pelanggan ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $t->nomor_meja ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    {{ $t->metode_pembayaran }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $t->details->count() }} item</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-800">Rp {{ number_format($t->total) }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('kasir.cetak', $t->id) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                                    <i class="ph ph-printer"></i> Cetak Ulang
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot class="bg-green-50 border-t-2 border-green-200">
                        <tr>
                            <th colspan="6" class="px-6 py-4 text-right text-base font-bold text-green-800">
                                TOTAL HARI INI
                            </th>
                            <th colspan="2" class="px-6 py-4 text-left text-lg font-bold text-green-800">
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