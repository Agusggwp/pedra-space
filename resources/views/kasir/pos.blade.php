<!DOCTYPE html>
<html lang="id"><head><title>Kasir POS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>body{background:#667eea;color:white;}.card{border-radius:20px;}</style></head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Kasir: {{ auth()->user()->name }}</h2>
        <div>
            <a href="{{ route('kasir.tutup.form') }}" class="btn btn-danger">Tutup Kasir</a>
            <a href="{{ route('kasir.daftar') }}" class="btn btn-info">Daftar Penjualan</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card bg-white text-dark">
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($produks as $p)
                        <div class="col-4">
                            <form action="{{ route('kasir.tambah') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $p->id }}">
                                <button type="submit" class="btn btn-outline-primary w-100 p-4">
                                    <strong>{{ $p->nama }}</strong><br>
                                    Rp {{ number_format($p->harga_jual) }}<br>
                                    <small class="badge bg-success">Stok: {{ $p->stok }}</small>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-dark text-white">
                <div class="card-header bg-success">
                    <h4>Keranjang ({{ count($keranjang) }})</h4>
                </div>
                <div class="card-body">
                    @if(empty($keranjang))
                        <p class="text-center">Keranjang kosong</p>
                    @else
                        <table class="table table-dark">
                            @foreach($keranjang as $id => $item)
                            <tr>
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ $item['jumlah'] }} × {{ number_format($item['harga']) }}</td>
                                <td>
                                    <form action="{{ route('kasir.hapus', $id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">×</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr class="table-success">
                                <th colspan="2">TOTAL</th>
                                <th>Rp {{ number_format(collect($keranjang)->sum(fn($i) => $i['harga'] * $i['jumlah'])) }}</th>
                            </tr>
                        </table>

                        <form action="{{ route('kasir.bayar') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Metode</label>
                                <select name="metode" class="form-select" required>
                                    <option value="Tunai">Tunai</option>
                                    <option value="EDC">EDC / Kartu</option>
                                    <option value="QRIS">QRIS</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Bayar</label>
                                <input type="number" name="bayar" class="form-control form-control-lg text-end" required>
                            </div>
                            <button class="btn btn-success btn-lg w-100">BAYAR & CETAK</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body></html>