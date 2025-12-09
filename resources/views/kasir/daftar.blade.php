<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Penjualan Hari Ini - Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            min-height: 100vh;
            color: white;
        }
        .table-dark th {
            background-color: rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="display-5 fw-bold">
            <i class="bi bi-receipt"></i> Daftar Penjualan Hari Ini
        </h1>
        <p class="lead">Kasir: <strong>{{ auth()->user()->name }}</strong> | {{ now()->format('d F Y') }}</p>
        <a href="{{ route('kasir.pos') }}" class="btn btn-light btn-lg">
            Kembali ke POS
        </a>
    </div>

    @if($transaksis->count() == 0)
        <div class="alert alert-info text-center">
            <h4>Belum Ada Penjualan Hari Ini</h4>
            <p>Silakan mulai transaksi di halaman POS.</p>
        </div>
    @else
        <div class="card bg-white text-dark shadow-lg">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Metode</th>
                                <th>Jumlah Item</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $i => $t)
                            <tr>
                                <td><strong>{{ $i + 1 }}</strong></td>
                                <td>{{ $t->created_at->format('H:i') }}</td>
                                <td>
                                    <span class="badge bg-success fs-6">
                                        {{ $t->metode_pembayaran }}
                                    </span>
                                </td>
                                <td>{{ $t->details->count() }} item</td>
                                <td class="fw-bold">Rp {{ number_format($t->total) }}</td>
                                <td>
                                    <a href="{{ route('kasir.cetak', $t->id) }}" 
                                       class="btn btn-primary btn-sm" target="_blank">
                                        <i class="bi bi-printer"></i> Cetak Ulang
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-success">
                            <tr>
                                <th colspan="4" class="text-end">TOTAL HARI INI</th>
                                <th colspan="2">Rp {{ number_format($transaksis->sum('total')) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="text-center mt-4">
        <form action="{{ url('/logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-outline-light" 
                    onclick="return confirm('Yakin ingin logout?')">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>