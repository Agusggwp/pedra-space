<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tutup Kasir - Sistem POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            background: #1e293b;
            box-shadow: 8px 0 30px rgba(0,0,0,0.3);
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
        .text-gradient {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        body {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            min-height: 100vh;
            color: white;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>

@include('kasir.partials.sidebar')

<!-- MAIN CONTENT -->
<div class="lg:ml-[320px] p-8">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-cash-stack display-1 text-warning"></i>
                    <h2 class="mt-3">Tutup Kasir Hari Ini</h2>
                    <p>Kasir: <strong>{{ auth()->user()->name }}</strong></p>
                </div>

                <div class="bg-white text-dark rounded p-4 mb-4">
                    <h5>Ringkasan Shift</h5>
                    <table class="table table-bordered mb-0">
                        <tr><th>Saldo Awal</th><td class="text-end"><strong>Rp {{ number_format($shift->saldo_awal) }}</strong></td></tr>
                        
                        <tr class="table-info">
                            <th colspan="2" class="text-center fw-bold">📊 Rincian Penjualan</th>
                        </tr>
                        <tr>
                            <th><i class="bi bi-cash-coin"></i> Penjualan Tunai</th>
                            <td class="text-end"><strong>Rp {{ number_format($transaksiTunai) }}</strong></td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-credit-card"></i> Penjualan EDC (Kartu)</th>
                            <td class="text-end"><strong>Rp {{ number_format($transaksiEDC) }}</strong></td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-qr-code"></i> Penjualan QRIS</th>
                            <td class="text-end"><strong>Rp {{ number_format($transaksiQRIS) }}</strong></td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-arrow-left-right"></i> Penjualan Transfer</th>
                            <td class="text-end"><strong>Rp {{ number_format($transaksiTransfer) }}</strong></td>
                        </tr>

                        <tr class="table-warning">
                            <th><i class="bi bi-currency-exchange"></i> Total Penjualan (Semua Metode)</th>
                            <td class="text-end"><strong>Rp {{ number_format($transaksiTunai + $transaksiEDC + $transaksiQRIS + $transaksiTransfer) }}</strong></td>
                        </tr>

                        <tr class="table-success">
                            <th>Harusnya Ada (Saldo Awal + Penjualan Tunai)</th>
                            <td class="text-end"><strong>Rp {{ number_format($shift->saldo_awal + $transaksiTunai) }}</strong></td>
                        </tr>
                    </table>
                </div>

                <form action="{{ route('kasir.tutup') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fs-5">Masukkan Saldo Akhir (Uang di Laci)</label>
                        <input type="number" name="saldo_akhir" class="form-control form-control-lg text-end" 
                               step="100" min="0" placeholder="0" required>
                        <small class="text-white-50">Hitung semua uang fisik di laci kasir</small>
                    </div>

                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="bi bi-lock"></i> TUTUP KASIR & HITUNG SELISIH
                        </button>
                        <a href="{{ route('kasir.pos') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> Kembali ke POS
                        </a>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <small class="text-white-50">
                        Setelah ditutup, kamu tidak bisa transaksi lagi sampai buka kasir besok.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>