<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #eee; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

<h2>Laporan Penjualan</h2>

<table>
    <thead>
        <tr>
            <th>Kode Transaksi</th>
            <th>Nama Kasir</th>
            <th>Total</th>
            <th>Metode</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($transaksi as $item)
            <tr>
                <!-- KODE TRX FORMAT TRX-000001 -->
                <td>{{ 'TRX-' . str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</td>

                <!-- NAMA KASIR -->
                <td>{{ $item->kasir->name ?? '-' }}</td>

                <!-- TOTAL -->
                <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>

                <!-- METODE PEMBAYARAN -->
                <td>{{ ucfirst($item->metode_pembayaran ?? '-') }}</td>

                <!-- STATUS -->
                <td>{{ ucfirst($item->status) }}</td>

                <!-- TANGGAL -->
                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
