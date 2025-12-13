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

@include('kasir.partials.sidebar')

<!-- MAIN CONTENT -->
<div class="lg:ml-72 p-6 md:p-8">
    <div class="max-w-3xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <!-- BUTTON KEMBALI -->
            <a href="{{ route('kasir.pos') }}" 
               class="inline-flex items-center gap-2 text-gray-700 hover:text-gray-900 transition mb-6 bg-gray-200 px-3 py-2 rounded-lg">
                <i class="ph ph-arrow-left text-lg"></i>
                <span class="text-sm font-medium">Kembali ke POS</span>
            </a>
            
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

                <!-- HARUSNYA ADA -->
                <div class="flex justify-between items-center p-3 bg-green-50 border-2 border-green-200 rounded-lg">
                    <span class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <i class="ph ph-calculator text-xl text-green-600"></i>
                        Harusnya Ada di Laci
                    </span>
                    <span class="text-base font-bold text-green-600">
                        Rp {{ number_format($shift->saldo_awal + $transaksiTunai) }}
                    </span>
                </div>

                <p class="text-xs text-gray-600 italic mt-2">
                    * Saldo Awal + Penjualan Tunai = Jumlah uang fisik yang seharusnya ada di laci kasir
                </p>

            </div>
        </div>

        <!-- FORM TUTUP KASIR -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 md:p-6">
            <form action="{{ route('kasir.tutup') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Masukkan Saldo Akhir (Uang di Laci) <span class="text-red-500">*</span>
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
                        Hitung semua uang fisik yang ada di laci kasir
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

                    <a href="{{ route('kasir.pos') }}" 
                       class="w-full px-5 py-3 bg-white text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-bold flex items-center justify-center gap-2 text-sm">
                        <i class="ph ph-arrow-left text-lg"></i>
                        <span>Batal & Kembali ke POS</span>
                    </a>
                </div>

            </form>
        </div>

        <!-- FOOTER INFO -->
        <div class="text-center mt-5 text-xs text-gray-500">
            <p>Sistem akan otomatis menghitung selisih antara saldo akhir dengan harusnya ada</p>
        </div>

    </div>
</div>

</body>
</html>