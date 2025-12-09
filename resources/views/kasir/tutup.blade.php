<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tutup Kasir - Sistem POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
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
                    <table class="table table-bordered">
                        <tr><th>Saldo Awal</th><td class="text-end"><strong>Rp {{ number_format($shift->saldo_awal) }}</strong></td></tr>
                        <tr><th>Penjualan Tunai & EDC</th><td class="text-end"><strong>Rp {{ number_format($transaksiTunaiEDC) }}</strong></td></tr>
                        <tr class="table-success">
                            <th>Harusnya Ada</th>
                            <td class="text-end"><strong>Rp {{ number_format($shift->saldo_awal + $transaksiTunaiEDC) }}</strong></td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>