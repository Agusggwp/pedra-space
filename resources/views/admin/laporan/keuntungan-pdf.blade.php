<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuntungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            margin-bottom: 5px;
        }
        .header-info {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .summary-box {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
            padding: 10px;
        }
        .summary-item {
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .summary-item p {
            margin: 0;
            font-size: 11px;
            color: #666;
        }
        .summary-item .value {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: left;
            border: 1px solid #333;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="header-info">
    <h1>Laporan Keuntungan</h1>
    <p>Bulan: <strong>{{ ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$bulan] }} {{ $tahun }}</strong></p>
    <p>Tanggal Cetak: {{ now()->format('d M Y H:i') }}</p>
</div>

<div class="summary-box">
    <div class="summary-item">
        <p>Total Penjualan</p>
        <div class="value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
    </div>
    <div class="summary-item">
        <p>Total Modal (Harga Beli)</p>
        <div class="value">Rp {{ number_format($totalHargaBeli, 0, ',', '.') }}</div>
    </div>
    <div class="summary-item">
        <p>Total Keuntungan</p>
        <div class="value">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</div>
    </div>
    <div class="summary-item">
        <p>Margin Keuntungan</p>
        <div class="value">{{ $totalPenjualan > 0 ? number_format(($totalKeuntungan / $totalPenjualan) * 100, 2) : 0 }}%</div>
    </div>
</div>

<h2>Detail Keuntungan per Produk</h2>

@if($keuntungan->count() > 0)
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Harga Jual</th>
                <th class="text-right">Total Beli</th>
                <th class="text-right">Total Jual</th>
                <th class="text-right">Keuntungan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keuntungan->groupBy('produk_id') as $items)
                @php
                    $first = $items->first();
                    $totalQty = $items->sum(function($item) { return $item->jumlah ?? $item->qty ?? 0; });
                    $totalJual = $items->sum(function($item) { 
                        $hargaSatuan = $item->harga_satuan ?? $item->harga ?? 0;
                        $jumlah = $item->jumlah ?? $item->qty ?? 0;
                        return $hargaSatuan * $jumlah;
                    });
                    $totalBeli = $items->sum(function($item) { 
                        $hargaBeli = $item->produk->harga_beli ?? 0;
                        $jumlah = $item->jumlah ?? $item->qty ?? 0;
                        return $hargaBeli * $jumlah;
                    });
                    $totalKeuntunganProduk = $totalJual - $totalBeli;
                    $hargaSatuanDisplay = $first->harga_satuan ?? $first->harga ?? 0;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $first->produk->nama ?? 'N/A' }}</td>
                    <td class="text-right">{{ $totalQty }}</td>
                    <td class="text-right">Rp {{ number_format($first->produk->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($hargaSatuanDisplay, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalBeli, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalJual, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($totalKeuntunganProduk, 0, ',', '.') }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p style="text-align: center; padding: 20px; color: #999;">Tidak ada data keuntungan untuk periode ini</p>
@endif

<div class="footer">
    <p>© 2025 Pedra Kopi - Sistem POS | Laporan Confidential</p>
</div>

</body>
</html>
