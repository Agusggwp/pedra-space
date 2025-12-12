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
            background-color: #f5f5f5;
            color: #333;
            min-height: 100vh;
        }

        .table thead th {
            background: #e9ecef !important;
            color: #333;
            font-weight: bold;
        }

        .card {
            border-radius: 18px;
        }

        .btn-light {
            background: white;
            border: 1px solid #ddd;
        }

        .btn-light:hover {
            background: #f0f0f0;
        }

        .badge {
            padding: 6px 10px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <!-- HEADER -->
    <div class="text-center mb-4">
        <h1 class="fw-bold">
            <i class="bi bi-receipt"></i> Daftar Penjualan Hari Ini
        </h1>

        <p class="text-muted">
            Kasir: <strong>{{ auth()->user()->name }}</strong> |
            {{ now()->format('d F Y') }}
        </p>

        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('kasir.pos') }}" class="btn btn-light btn-lg shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali ke POS
            </a>

            <!-- 🔥 TOMBOL KEMBALI KE DASHBOARD -->
            <a href="{{ route('kasir.dashboard') }}" class="btn btn-dark btn-lg shadow-sm">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- JIKA KOSONG -->
    @if($transaksis->count() == 0)
        <div class="alert alert-light text-center shadow-sm">
            <h4 class="mb-1">Belum Ada Penjualan Hari Ini</h4>
            <p class="text-muted mb-0">Silakan mulai transaksi di halaman POS.</p>
        </div>

    @else
    
    <!-- TABEL TRANSAKSI -->
    <div class="card bg-white shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Pelanggan</th>
                            <th>Meja</th>
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
                            <td>{{ $t->nama_pelanggan ?? '-' }}</td>
                            <td>{{ $t->nomor_meja ?? '-' }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ $t->metode_pembayaran }}
                                </span>
                            </td>
                            <td>{{ $t->details->count() }} item</td>
                            <td class="fw-bold">Rp {{ number_format($t->total) }}</td>
                            <td>
                                <a href="{{ route('kasir.cetak', $t->id) }}" 
                                   class="btn btn-primary btn-sm"
                                   target="_blank">
                                    <i class="bi bi-printer"></i> Cetak Ulang
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="table-success">
                            <th colspan="4" class="text-end">TOTAL HARI INI</th>
                            <th colspan="2" class="fw-bold">
                                Rp {{ number_format($transaksis->sum('total')) }}
                            </th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>

    @endif

    <!-- LOGOUT -->
    <div class="text-center mt-4">
        <form action="{{ url('/logout') }}" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-outline-dark"
                    onclick="return confirm('Yakin ingin logout?')">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

</div>

</body>
</html>
