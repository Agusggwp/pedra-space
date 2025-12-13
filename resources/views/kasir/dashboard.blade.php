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
            background: #1e293b;
            box-shadow: 8px 0 30px rgba(0,0,0,0.3);
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
        .menu-item {
            color: #94a3b8;
            transition: all 0.2s ease;
        }
        .menu-item:hover {
            color: #e2e8f0;
            background: rgba(255,255,255,0.05);
        }
        .menu-item.active {
            background: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">

@include('kasir.partials.sidebar')

<!-- MAIN CONTENT -->
<div class="lg:ml-[320px] p-8">

    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold text-gradient">
            Selamat Datang, {{ auth()->user()->name }}!
        </h1>
        <p class="text-xl text-gray-600 mt-3">Kasir Sistem POS — Siap Melayani Pelanggan</p>
    </div>

    <!-- Shift Status -->
    @php
        $shiftAktif = \App\Models\ShiftKasir::buka()->where('user_id', auth()->id())->first();
    @endphp

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