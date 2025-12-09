<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Kasir - Sistem POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            color: white;
        }
        .card-dashboard {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: 0.3s;
        }
        .card-dashboard:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .btn-custom {
            border-radius: 15px;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <!-- Header Selamat Datang -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">
            <i class="bi bi-person-circle"></i> Selamat Datang, {{ auth()->user()->name }}!
        </h1>
        <p class="lead">Kasir Sistem POS - Siap Melayani Pelanggan</p>
        <hr class="bg-white">
    </div>

    <!-- Cek Status Shift -->
    @php
        $shiftAktif = \App\Models\ShiftKasir::buka()->where('user_id', auth()->id())->first();
    @endphp

    @if(!$shiftAktif)
        <div class="alert alert-warning text-center">
            <h4>Kasir Belum Dibuka!</h4>
            <p>Silakan buka kasir terlebih dahulu untuk memulai penjualan hari ini.</p>
            <a href="{{ route('kasir.buka') }}" class="btn btn-success btn-lg">
                Buka Kasir Sekarang
            </a>
        </div>
    @else
        <div class="alert alert-success text-center">
            <h4>Kasir Sudah Dibuka</h4>
            <p>Saldo Awal: <strong>Rp {{ number_format($shiftAktif->saldo_awal) }}</strong></p>
        </div>
    @endif

    <!-- Menu Utama Kasir -->
    <div class="row g-4 mt-4">
        <!-- POS Penjualan -->
        <div class="col-md-4">
            <div class="card-dashboard text-center p-5 shadow">
                <i class="bi bi-cart-check display-1 mb-3"></i>
                <h3>Penjualan</h3>
                <p class="mb-4">Mulai transaksi penjualan baru</p>
                <a href="{{ route('kasir.pos') }}" class="btn btn-primary btn-custom">
                    Buka POS
                </a>
            </div>
        </div>

        <!-- Daftar Penjualan Hari Ini -->
        <div class="col-md-4">
            <div class="card-dashboard text-center p-5 shadow">
                <i class="bi bi-receipt display-1 mb-3"></i>
                <h3>Daftar Penjualan</h3>
                <p class="mb-4">Lihat semua transaksi hari ini (Tunai & EDC)</p>
                <a href="{{ route('kasir.daftar') }}" class="btn btn-info btn-custom text-white">
                    Lihat Daftar
                </a>
            </div>
        </div>

        <!-- Tutup Kasir -->
        <div class="col-md-4">
            <div class="card-dashboard text-center p-5 shadow">
                <i class="bi bi-box-arrow-right display-1 mb-3"></i>
                <h3>Tutup Kasir</h3>
                <p class="mb-4">Selesaikan shift & hitung selisih</p>
                @if($shiftAktif)
                    <a href="{{ route('kasir.tutup.form') }}" class="btn btn-danger btn-custom">
                        Tutup Kasir
                    </a>
                @else
                    <button class="btn btn-secondary btn-custom" disabled>Tutup Kasir</button>
                @endif
            </div>
        </div>
    </div>

    <!-- Tombol Logout -->
    <div class="text-center mt-5">
        <form action="{{ url('/logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-lg" 
                    onclick="return confirm('Yakin ingin keluar dari sistem?')">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <div class="text-center mt-5 text-white-50">
        <small>© {{ date('Y') }} Sistem POS Sederhana - Dibuat dengan Laravel</small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>