<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Void/Batalkan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 11px;
        }
        h1 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 16px;
        }
        .header-info {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header-info p {
            margin: 5px 0;
            font-size: 11px;
        }
        .summary-box {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
            padding: 10px;
        }
        .summary-item {
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 3px;
        }
        .summary-item p {
            margin: 0;
            font-size: 10px;
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
            padding: 8px;
            text-align: left;
            border: 1px solid #333;
            font-weight: bold;
            font-size: 10px;
        }
        td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            font-size: 10px;
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
        .details-section {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f0f0f0;
            border-left: 3px solid #d32f2f;
            border-radius: 3px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .keterangan {
            font-size: 9px;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>

<div class="header-info">
    <h1>LAPORAN TRANSAKSI VOID / DIBATALKAN</h1>
    @if($bulan)
        <p><strong>Periode:</strong> {{ $namabulan }} {{ $tahun }}</p>
    @else
        <p><strong>Periode:</strong> Tahun {{ $tahun }}</p>
    @endif
    <p><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y H:i') }}</p>
</div>

@if($transaksis->count() > 0)
    <div class="summary-box">
        <div class="summary-item">
            <p>Total Transaksi Void</p>
            <div class="value">{{ $transaksis->count() }}</div>
        </div>
        <div class="summary-item">
            <p>Total Nilai Void</p>
            <div class="value">Rp {{ number_format($totalVoid, 0, ',', '.') }}</div>
        </div>
        <div class="summary-item">
            <p>Rata-rata Void</p>
            <div class="value">Rp {{ number_format($transaksis->count() > 0 ? $totalVoid / $transaksis->count() : 0, 0, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%">ID</th>
                <th style="width: 12%">Tanggal Void</th>
                <th style="width: 12%">Kasir</th>
                <th style="width: 12%">Dibatalkan Oleh</th>
                <th style="width: 14%" class="text-right">Total</th>
                <th style="width: 42%">Alasan Pembatalan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $t)
            <tr>
                <td><strong>#{{ $t->id }}</strong></td>
                <td>{{ $t->void_at ? $t->void_at->format('d/m/Y H:i') : '-' }}</td>
                <td>{{ $t->user->name }}</td>
                <td>{{ $t->voidBy?->name ?? '-' }}</td>
                <td class="text-right"><strong>Rp {{ number_format($t->total, 0, ',', '.') }}</strong></td>
                <td class="keterangan">{{ $t->keterangan_void ?: '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; padding: 15px; background-color: #f0f0f0; border-radius: 3px; border-left: 4px solid #d32f2f;">
        <p style="margin: 0; font-weight: bold; color: #333;"><strong>RINGKASAN:</strong></p>
        <p style="margin: 5px 0;">Total Transaksi Dibatalkan: <strong>{{ $transaksis->count() }}</strong> transaksi</p>
        <p style="margin: 5px 0;">Total Nilai Refund: <strong>Rp {{ number_format($totalVoid, 0, ',', '.') }}</strong></p>
        <p style="margin: 5px 0;">Rata-rata Nilai Void: <strong>Rp {{ number_format($transaksis->count() > 0 ? $totalVoid / $transaksis->count() : 0, 0, ',', '.') }}</strong></p>
    </div>
@else
    <div style="text-align: center; padding: 40px; color: #999;">
        <p style="font-size: 14px;">Tidak ada transaksi yang dibatalkan untuk periode ini</p>
    </div>
@endif

<div class="footer">
    <p>© 2025 Pedra Kopi - Sistem POS | Laporan Confidential</p>
</div>

</body>
</html>
