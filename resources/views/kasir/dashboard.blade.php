<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Kasir - POS</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            background: #f8fafc;
            color: #1e293b;
        }
        .sidebar {
            background: #ffffff;
            box-shadow: 8px 0 30px rgba(0,0,0,0.08);
            border-right: 1px solid #e2e8f0;
        }
        .card-hover {
            background: white;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-color: #3b82f6;
        }
        .btn-primary { background: #3b82f6; }
        .btn-primary:hover { background: #2563eb; }
        .btn-success { background: #10b981; }
        .btn-success:hover { background: #059669; }
        .btn-danger { background: #ef4444; }
        .btn-danger:hover { background: #dc2626; }
        .btn-info { background: #0ea5e9; }
        .btn-info:hover { background: #0284c7; }
        .text-gradient {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50">

<!-- SIDEBAR -->
<div id="sidebar" class="fixed inset-y-0 left-0 w-72 sidebar text-gray-800 p-8 transform -translate-x-full transition-all duration-300 lg:translate-x-0 z-50 flex flex-col">
    
    <!-- Logo & User -->
    <div class="text-center mb-10">
        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
            {{ Str::substr(auth()->user()->name, 0, 1) }}
        </div>
        <h3 class="text-2xl font-bold">{{ auth()->user()->name }}</h3>
        <p class="text-gray-500 text-sm">Kasir Aktif</p>
    </div>

    <!-- Menu -->
    <nav class="space-y-4 flex-1">
        <a href="{{ route('kasir.pos') }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-blue-50 transition bg-blue-50 border border-blue-200">
            <i class="ph ph-shopping-cart text-2xl text-blue-600"></i>
            <span class="font-semibold">Penjualan (POS)</span>
        </a>
        <a href="{{ route('kasir.daftar') }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-sky-50 transition">
            <i class="ph ph-receipt text-2xl text-sky-600"></i>
            <span class="font-semibold">Daftar Penjualan</span>
        </a>
        <a href="{{ route('kasir.update-stok') }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-green-50 transition border border-green-200">
            <i class="ph ph-package text-2xl text-green-600"></i>
            <span class="font-semibold">Update Stok</span>
        </a>

        @php
            $shiftAktif = \App\Models\ShiftKasir::buka()->where('user_id', auth()->id())->first();
        @endphp

        @if($shiftAktif)
        <a href="{{ route('kasir.tutup.form') }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-red-50 transition border border-red-200">
            <i class="ph ph-door text-2xl text-red-600"></i>
            <span class="font-semibold">Tutup Kasir</span>
        </a>
        @else
        <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-100 text-gray-400 cursor-not-allowed">
            <i class="ph ph-door text-2xl"></i>
            <span class="font-semibold">Tutup Kasir</span>
        </div>
        @endif

        <form action="{{ url('/logout') }}" method="POST" class="mt-8">
            @csrf
            <button class="w-full flex items-center gap-4 p-4 rounded-2xl hover:bg-red-50 transition border border-red-200 text-red-600">
                <i class="ph ph-sign-out text-2xl"></i>
                <span class="font-semibold">Logout</span>
            </button>
        </form>
    </nav>

    <!-- FOOTER ARTDEVATA — PALING BAWAH SIDEBAR -->
    <div class="mt-auto pt-8 border-t border-gray-200 text-center">
        <p class="text-xs text-gray-500 mb-2">Dibuat oleh</p>
        <a href="https://artdevata.net" target="_blank" class="text-lg font-bold text-gradient hover:opacity-80 transition">
            ArtDevata
        </a>
        <p class="text-xs text-gray-400 mt-1">artdevata.net • Bali</p>
        <p class="text-xs text-gray-400 mt-4">© {{ date('Y') }} • Bali Time (WITA)</p>
    </div>
</div>

<!-- TOGGLE SIDEBAR (Mobile) -->
<button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')"
        class="lg:hidden fixed top-6 left-6 bg-white shadow-lg text-gray-700 p-4 rounded-2xl z-50 border">
    <i class="ph ph-list text-2xl"></i>
</button>

<!-- MAIN CONTENT -->
<div class="lg:ml-72 p-8">

    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold text-gradient">
            Selamat Datang, {{ auth()->user()->name }}!
        </h1>
        <p class="text-xl text-gray-600 mt-3">Kasir Sistem POS — Siap Melayani Pelanggan</p>
    </div>

    <!-- Shift Status -->
    @if(!$shiftAktif)
    <div class="max-w-3xl mx-auto bg-yellow-50 border-2 border-yellow-300 text-yellow-800 p-10 rounded-3xl text-center mb-12 shadow-lg">
        <i class="ph ph-warning-circle text-7xl mb-6"></i>
        <h2 class="text-3xl font-bold mb-4">Kasir Belum Dibuka!</h2>
        <p class="text-lg mb-8">Silakan buka kasir untuk memulai penjualan hari ini.</p>
        <a href="{{ route('kasir.buka') }}" class="bg-green-600 hover:bg-green-700 text-white px-10 py-5 rounded-2xl text-2xl font-bold inline-flex items-center gap-4 shadow-lg">
            <i class="ph ph-cash-register text-3xl"></i> Buka Kasir Sekarang
        </a>
    </div>
    @else
    <div class="max-w-3xl mx-auto bg-green-50 border-2 border-green-300 text-green-800 p-10 rounded-3xl text-center mb-12 shadow-lg">
        <i class="ph ph-check-circle text-7xl text-green-500 mb-6"></i>
        <h2 class="text-3xl font-bold mb-4">Kasir Sudah Dibuka</h2>
        <p class="text-2xl">Saldo Awal: <strong>Rp {{ number_format($shiftAktif->saldo_awal) }}</strong></p>
    </div>
    @endif

    <!-- Menu Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
        <div class="card-hover rounded-3xl p-10 text-center">
            <i class="ph ph-shopping-cart text-7xl text-blue-500 mb-6"></i>
            <h3 class="text-3xl font-bold mb-3">Penjualan</h3>
            <p class="text-gray-600 mb-8">Mulai transaksi baru sekarang</p>
            <a href="{{ route('kasir.pos') }}" class="btn-primary text-white px-8 py-4 rounded-2xl text-xl font-bold shadow-lg block">
                Buka POS
            </a>
        </div>
        <div class="card-hover rounded-3xl p-10 text-center">
            <i class="ph ph-receipt text-7xl text-sky-500 mb-6"></i>
            <h3 class="text-3xl font-bold mb-3">Daftar Penjualan</h3>
            <p class="text-gray-600 mb-8">Lihat semua transaksi hari ini</p>
            <a href="{{ route('kasir.daftar') }}" class="btn-info text-white px-8 py-4 rounded-2xl text-xl font-bold shadow-lg block">
                Lihat Daftar
            </a>
        </div>
        <div class="card-hover rounded-3xl p-10 text-center border-2 border-green-300">
            <i class="ph ph-package text-7xl text-green-500 mb-6"></i>
            <h3 class="text-3xl font-bold mb-3">Update Stok</h3>
            <p class="text-gray-600 mb-8">Tambah/kurangi stok dengan cepat</p>
            <a href="{{ route('kasir.update-stok') }}" class="btn-success text-white px-8 py-4 rounded-2xl text-xl font-bold shadow-lg block">
                Update Stok
            </a>
        </div>
        <div class="card-hover rounded-3xl p-10 text-center">
            <i class="ph ph-door text-7xl text-red-500 mb-6"></i>
            <h3 class="text-3xl font-bold mb-3">Tutup Kasir</h3>
            <p class="text-gray-600 mb-8">Selesaikan shift hari ini</p>
            @if($shiftAktif)
                <a href="{{ route('kasir.tutup.form') }}" class="btn-danger text-white px-8 py-4 rounded-2xl text-xl font-bold shadow-lg block">
                    Tutup Kasir
                </a>
            @else
                <button disabled class="bg-gray-400 text-white px-8 py-4 rounded-2xl text-xl cursor-not-allowed">
                    Tutup Kasir
                </button>
            @endif
        </div>
    </div>
</div>

</body>
</html>