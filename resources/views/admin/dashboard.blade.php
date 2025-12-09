<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #2c3e50, #1a2530); }
        .nav-link { color: #bdc3c7; border-radius: 8px; margin: 5px 10px; }
        .nav-link:hover, .nav-link.active { background-color: #34495e; color: white !important; }
        .nav-link i { width: 25px; }
    </style>
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR KIRI -->
    <div class="sidebar text-white p-3" style="width: 280px;">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-white">POS ADMIN</h4>
            <hr class="bg-light">
            <small class="text-info">{{ auth()->user()->name }}</small>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link active" href="{{ url('/admin/dashboard') }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>

            <hr class="bg-secondary">

            <a class="nav-link" href="{{ url('/admin/users') }}">
                <i class="bi bi-people"></i> Manajemen User
            </a>
            <a class="nav-link" href="{{ url('/admin/produk') }}">
                <i class="bi bi-box-seam"></i> Manajemen Produk
            </a>
            <a class="nav-link" href="{{ url('/admin/stok') }}">
                <i class="bi bi-bar-chart-line"></i> Manajemen Stok
            </a>
            <a class="nav-link" href="{{ url('/admin/void') }}">
                <i class="bi bi-arrow-counterclockwise"></i> Void / Refund
            </a>
            <a class="nav-link" href="{{ url('/admin/laporan') }}">
                <i class="bi bi-graph-up-arrow"></i> Laporan Penjualan
            </a>
            <a class="nav-link" href="{{ url('/admin/pengaturan') }}">
                <i class="bi bi-gear"></i> Pengaturan Outlet
            </a>
            <a class="nav-link" href="{{ url('/admin/backup') }}">
                <i class="bi bi-cloud-download"></i> Backup & Restore
            </a>

            <hr class="bg-secondary">

            <!-- Logout di sidebar (POST) -->
            <form action="{{ url('/logout') }}" method="POST" class="m-2">
                @csrf
                <button type="submit" class="nav-link text-danger bg-transparent border-0 text-start w-100"
                        onclick="return confirm('Yakin ingin keluar?')">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- KONTEN UTAMA (Dashboard Ringkas) -->
    <div class="flex-grow-1 p-4">
        <h2 class="mb-4 text-primary">
            <i class="bi bi-speedometer2"></i> Dashboard Utama
        </h2>

        <div class="row g-4">

            <!-- Total Penjualan Hari Ini -->
            <div class="col-md-3">
                <div class="card border-success shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-stack text-success" style="font-size: 2.5rem;"></i>
                        <h5 class="mt-2">Penjualan Hari Ini</h5>
                        <h3 class="text-success">Rp 2.450.000</h3>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi Hari Ini -->
            <div class="col-md-3">
                <div class="card border-info shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-receipt text-info" style="font-size: 2.5rem;"></i>
                        <h5 class="mt-2">Transaksi Hari Ini</h5>
                        <h3 class="text-info">48</h3>
                    </div>
                </div>
            </div>

            <!-- Produk Hampir Habis -->
            <div class="col-md-3">
                <div class="card border-warning shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2.5rem;"></i>
                        <h5 class="mt-2">Stok Kritis</h5>
                        <h3 class="text-warning">12 Item</h3>
                    </div>
                </div>
            </div>

            <!-- User Aktif -->
            <div class="col-md-3">
                <div class="card border-primary shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-person-check text-primary" style="font-size: 2.5rem;"></i>
                        <h5 class="mt-2">Kasir Aktif</h5>
                        <h3 class="text-primary">5 Orang</h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- Info Tambahan -->
        <div class="mt-5">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Tips:</strong> Gunakan menu di sidebar kiri untuk mengakses semua fitur admin.
                Semua perubahan langsung tersimpan secara real-time.
            </div>
        </div>

        <div class="text-center mt-5 text-muted">
            <small>© 2025 Sistem POS Sederhana - Laravel 12</small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>