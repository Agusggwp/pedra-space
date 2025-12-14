<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Kasir - POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-50">

@include('components.topbar')
@include('kasir.partials.sidebar')

<!-- MAIN CONTENT -->
<div class="lg:ml-72 p-6 md:p-8">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-gray-600">Kasir Sistem POS — Siap Melayani Pelanggan</p>
        </div>

        <!-- SHIFT STATUS -->
        @php
            $shiftAktif = \App\Models\ShiftKasir::buka()->where('user_id', auth()->id())->first();
        @endphp

        @if(!$shiftAktif)
        <!-- KASIR BELUM DIBUKA -->
        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-300 rounded-2xl p-8 mb-8 shadow-lg">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 bg-yellow-400 rounded-full flex items-center justify-center">
                        <i class="ph-fill ph-warning-circle text-5xl text-white"></i>
                    </div>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-yellow-800 mb-2">Kasir Belum Dibuka!</h2>
                    <p class="text-yellow-700 mb-4">Silakan buka kasir untuk memulai penjualan hari ini.</p>
                    <a href="{{ route('kasir.buka') }}" 
                       class="inline-flex items-center gap-3 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold shadow-md transition transform hover:scale-105">
                        <i class="ph-fill ph-cash-register text-2xl"></i>
                        <span>Buka Kasir Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
        @else
        <!-- KASIR SUDAH DIBUKA -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-300 rounded-2xl p-8 mb-8 shadow-lg">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="ph-fill ph-check-circle text-5xl text-white"></i>
                    </div>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-green-800 mb-2">Kasir Sudah Dibuka ✓</h2>
                    <p class="text-green-700 text-lg">
                        Saldo Awal: <span class="font-bold text-xl">Rp {{ number_format($shiftAktif->saldo_awal) }}</span>
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- MENU CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- PENJUALAN POS -->
            <a href="{{ route('kasir.pos') }}" 
               class="group bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border-2 border-transparent hover:border-blue-300">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-blue-200 transition">
                        <i class="ph-fill ph-shopping-cart text-4xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Penjualan</h3>
                    <p class="text-sm text-gray-600 mb-4">Mulai transaksi baru</p>
                    <div class="mt-auto w-full">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold group-hover:bg-blue-700 transition">
                            Buka POS
                        </span>
                    </div>
                </div>
            </a>

            <!-- DAFTAR PENJUALAN -->
            <a href="{{ route('kasir.daftar') }}" 
               class="group bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border-2 border-transparent hover:border-sky-300">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-sky-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-sky-200 transition">
                        <i class="ph-fill ph-receipt text-4xl text-sky-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Daftar Penjualan</h3>
                    <p class="text-sm text-gray-600 mb-4">Lihat transaksi hari ini</p>
                    <div class="mt-auto w-full">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 bg-sky-600 text-white rounded-lg font-semibold group-hover:bg-sky-700 transition">
                            Lihat Daftar
                        </span>
                    </div>
                </div>
            </a>

            <!-- UPDATE STOK -->
            <a href="{{ route('kasir.update-stok') }}" 
               class="group bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border-2 border-transparent hover:border-green-300">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-200 transition">
                        <i class="ph-fill ph-package text-4xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Update Stok</h3>
                    <p class="text-sm text-gray-600 mb-4">Kelola stok produk</p>
                    <div class="mt-auto w-full">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 bg-green-600 text-white rounded-lg font-semibold group-hover:bg-green-700 transition">
                            Update Stok
                        </span>
                    </div>
                </div>
            </a>

            <!-- TUTUP KASIR -->
            @if($shiftAktif)
            <a href="{{ route('kasir.tutup.form') }}" 
               class="group bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border-2 border-transparent hover:border-red-300">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-red-200 transition">
                        <i class="ph-fill ph-door text-4xl text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Tutup Kasir</h3>
                    <p class="text-sm text-gray-600 mb-4">Selesaikan shift hari ini</p>
                    <div class="mt-auto w-full">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 bg-red-600 text-white rounded-lg font-semibold group-hover:bg-red-700 transition">
                            Tutup Kasir
                        </span>
                    </div>
                </div>
            </a>
            @else
            <div class="bg-white rounded-2xl p-6 shadow-md border-2 border-gray-200 opacity-60 cursor-not-allowed">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="ph-fill ph-door text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-400 mb-2">Tutup Kasir</h3>
                    <p class="text-sm text-gray-400 mb-4">Tidak tersedia</p>
                    <div class="mt-auto w-full">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-lg font-semibold cursor-not-allowed">
                            Tutup Kasir
                        </span>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- INFO FOOTER -->
        @include('kasir.partials.footer')
    </div>
</div>

</body>
</html>