<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Detail Shift #{{ $shift->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        h1, h2 {
            text-align: center;
        }
        .header-info {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .shift-info {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .shift-info p {
            margin: 5px 0;
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
        .summary {
            background-color: #f0f0f0;
            padding: 15px;
            margin-top: 10px;
            border: 1px solid #333;
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
    <h1>Laporan Detail Shift #{{ $shift->id }}</h1>
    <p>Kasir: <strong>{{ $shift->user->name ?? 'N/A' }}</strong></p>
    <p>Tanggal Cetak: {{ now()->format('d M Y H:i') }}</p>
</div>

<div class="shift-info">
    <p><strong>Dibuka Pada:</strong> {{ $shift->dibuka_pada->format('d M Y H:i') }}</p>
    <p><strong>Ditutup Pada:</strong> {{ $shift->ditutup_pada?->format('d M Y H:i') ?? 'Belum Ditutup' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($shift->status) }}</p>
    <p><strong>Saldo Awal:</strong> Rp {{ number_format($shift->saldo_awal ?? 0, 0, ',', '.') }}</p>
    <p><strong>Saldo Akhir:</strong> Rp {{ number_format($shift->saldo_akhir ?? 0, 0, ',', '.') }}</p>
    <p><strong>Selisih:</strong> Rp {{ number_format($shift->selisih ?? 0, 0, ',', '.') }}</p>
</div>

<h2>Daftar Transaksi ({{ $transaksi->count() }} transaksi)</h2>

@if($transaksi->count() > 0)
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ID Transaksi</th>
                <th>Waktu</th>
                <th>Metode</th>
                <th class="text-right">Total</th>
                <th class="text-right">Bayar</th>
                <th class="text-right">Kembalian</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>#{{ $item->id }}</td>
                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                    <td>{{ ucfirst($item->metode_pembayaran) }}</td>
                    <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->bayar, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                    <td class="text-center">{{ ucfirst($item->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p style="text-align: center; padding: 20px; color: #999;">Tidak ada transaksi untuk shift ini</p>
@endif

<div class="summary">
    <h3>Ringkasan Transaksi</h3>
    <table style="border: none; margin-top: 10px;">
        <tr style="border: none;">
            <td style="border: none;"><strong>Total Transaksi:</strong></td>
            <td style="border: none; text-align: right;"><strong>{{ $transaksi->count() }}</strong></td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;"><strong>Total Lunas:</strong></td>
            <td style="border: none; text-align: right;"><strong>{{ $transaksi->where('status', 'lunas')->count() }}</strong></td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;"><strong>Total Void:</strong></td>
            <td style="border: none; text-align: right;"><strong>{{ $transaksi->where('status', 'void')->count() }}</strong></td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;"><strong>Total Nilai (Lunas):</strong></td>
            <td style="border: none; text-align: right;"><strong>Rp {{ number_format($transaksi->where('status', 'lunas')->sum('total'), 0, ',', '.') }}</strong></td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;"><strong>Total Diterima:</strong></td>
            <td style="border: none; text-align: right;"><strong>Rp {{ number_format($transaksi->sum('bayar'), 0, ',', '.') }}</strong></td>
        </tr>
        <tr style="border: none;">
            <td style="border: none;"><strong>Total Kembalian:</strong></td>
            <td style="border: none; text-align: right;"><strong>Rp {{ number_format($transaksi->sum('kembalian'), 0, ',', '.') }}</strong></td>
        </tr>
    </table>
</div>

<div class="footer">
    <p>© 2025 Pedra Kopi - Sistem POS | Laporan Confidential</p>
</div>

</body>
</html>
