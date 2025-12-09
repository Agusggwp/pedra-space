<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir POS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f7f7f7;
            color: #333;
            min-height: 100vh;
        }

        .card {
            border-radius: 20px;
        }

        .produk-card {
            background: #ffffff;
            color: #333;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid #e5e5e5;
            transition: 0.2s;
            height: 100%;
        }

        .produk-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .produk-img {
            width: 100%;
            height: 130px;
            object-fit: cover;
            background: #fafafa;
        }

        .stok-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.8rem;
        }

        .harga {
            font-size: 1.2rem;
            font-weight: bold;
            color: #157347; /* hijau soft */
        }

        /* KERANJANG */
        .keranjang-card {
            background: #ffffff !important;
            color: #333 !important;
            border: 1px solid #e5e5e5;
        }

        .table-white {
            background: #ffffff;
        }

        .table-white td, .table-white th {
            background: #ffffff;
            color: #333;
        }

        .table-total {
            background: #e8f5e9 !important;
            color: #2e7d32 !important;
        }

    </style>
</head>
<body>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h3 class="mb-0 fw-bold">
            Kasir: <span class="text-primary">{{ auth()->user()->name }}</span>
        </h3>

        <div class="d-flex gap-2">
            <a href="{{ route('kasir.daftar') }}" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-receipt"></i> Daftar Penjualan
            </a>
            <a href="{{ route('kasir.tutup.form') }}" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-lock-fill"></i> Tutup Kasir
            </a>
        </div>
    </div>

    <div class="row g-4">

        <!-- PRODUK -->
        <div class="col-lg-8">
            <div class="card bg-white shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h4 class="mb-0 fw-semibold text-dark">
                        <i class="bi bi-box"></i> Pilih Produk
                    </h4>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">

                        @forelse($produks as $p)
                        <div class="col-6 col-md-4 col-lg-3 position-relative">
                            <form action="{{ route('kasir.tambah') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $p->id }}">

                                <button type="submit" class="produk-card border-0 p-0 w-100 text-start">

                                    @if($p->foto && file_exists(public_path($p->foto)))
                                        <img src="{{ asset($p->foto) }}" class="produk-img">
                                    @else
                                        <div class="produk-img d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image fs-1 text-secondary"></i>
                                        </div>
                                    @endif

                                    <span class="badge bg-success stok-badge">
                                        Stok: {{ $p->stok }}
                                    </span>

                                    <div class="p-2 text-center">
                                        <h6 class="fw-semibold mb-1">{{ Str::limit($p->nama, 20) }}</h6>
                                        <div class="harga">Rp {{ number_format($p->harga_jual) }}</div>
                                    </div>

                                </button>
                            </form>
                        </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="bi bi-box-seam display-3 text-muted"></i>
                                <p class="mt-2">Tidak ada produk</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>

        <!-- KERANJANG -->
        <div class="col-lg-4">
            <div class="card keranjang-card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                    <h4 class="mb-0 fw-bold">Keranjang ({{ count($keranjang) }})</h4>

                    @if(!empty($keranjang))
                        <span class="fw-semibold text-success">
                            Total: Rp {{ number_format(collect($keranjang)->sum(fn($i) => $i['harga'] * $i['jumlah'])) }}
                        </span>
                    @endif
                </div>

                <div class="card-body" style="max-height: 70vh; overflow-y: auto;">

                    @if(empty($keranjang))
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x display-1 text-muted"></i>
                            <p class="mt-3 text-muted">Keranjang kosong</p>
                        </div>

                    @else
                        <table class="table table-white table-hover keranjang-table">
                            @foreach($keranjang as $id => $item)
                            <tr>
                                <td>
                                    <strong>{{ $item['nama'] }}</strong><br>
                                    <small>{{ $item['jumlah'] }} × Rp {{ number_format($item['harga']) }}</small>
                                </td>

                                <td class="text-end fw-bold">
                                    Rp {{ number_format($item['harga'] * $item['jumlah']) }}
                                </td>

                                <td>
                                    <form action="{{ route('kasir.hapus', $id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            <tr class="table-total">
                                <th colspan="2" class="text-end">TOTAL BELANJA</th>
                                <th class="fw-bold">
                                    Rp {{ number_format(collect($keranjang)->sum(fn($i) => $i['harga'] * $i['jumlah'])) }}
                                </th>
                            </tr>
                        </table>

                        <!-- PEMBAYARAN -->
                        <form action="{{ route('kasir.bayar') }}" method="POST" class="mt-3">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <select name="metode" class="form-select form-select-lg" required>
                                    <option value="Tunai">Tunai</option>
                                    <option value="EDC">EDC / Kartu</option>
                                    <option value="QRIS">QRIS</option>
                                    <option value="Transfer">Transfer</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah Bayar</label>
                                <input type="number" 
                                       name="bayar" 
                                       class="form-control form-control-lg text-end" 
                                       min="{{ collect($keranjang)->sum(fn($i) => $i['harga'] * $i['jumlah']) }}" 
                                       placeholder="0" required>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">
                                <i class="bi bi-printer"></i> BAYAR & CETAK STRUK
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
