<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Per Shift User</title>
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
    <h1>Laporan Per Shift User (Kasir)</h1>
    <p>Tanggal Cetak: {{ now()->format('d M Y H:i') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Kasir</th>
            <th>Dibuka Pada</th>
            <th>Ditutup Pada</th>
            <th class="text-center">Transaksi (Total/Lunas/Void)</th>
            <th class="text-right">Saldo Awal</th>
            <th class="text-right">Saldo Akhir</th>
            <th class="text-right">Selisih</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($shiftData as $shift)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $shift->user->name ?? 'N/A' }}</td>
                <td>{{ $shift->dibuka_pada->format('d M Y H:i') ?? '-' }}</td>
                <td>{{ $shift->ditutup_pada?->format('d M Y H:i') ?? '-' }}</td>
                <td class="text-center">{{ $shift->transaksi_count }}/{{ $shift->transaksi_lunas }}/{{ $shift->transaksi_void }}</td>
                <td class="text-right">Rp {{ number_format($shift->saldo_awal ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($shift->saldo_akhir ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($shift->selisih ?? 0, 0, ',', '.') }}</td>
                <td class="text-center">{{ ucfirst($shift->status) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data shift ditemukan</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($shiftData->count() > 0)
    <div class="summary">
        <h3>Ringkasan</h3>
        <table style="margin-top: 10px; border: none;">
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Shift:</strong></td>
                <td style="border: none; text-align: right;"><strong>{{ $shiftData->count() }}</strong></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Transaksi:</strong></td>
                <td style="border: none; text-align: right;"><strong>{{ $shiftData->sum('transaksi_count') }}</strong></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Transaksi Lunas:</strong></td>
                <td style="border: none; text-align: right;"><strong>{{ $shiftData->sum('transaksi_lunas') }}</strong></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Transaksi Void:</strong></td>
                <td style="border: none; text-align: right;"><strong>{{ $shiftData->sum('transaksi_void') }}</strong></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Saldo Awal:</strong></td>
                <td style="border: none; text-align: right;"><strong>Rp {{ number_format($shiftData->sum('saldo_awal'), 0, ',', '.') }}</strong></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Saldo Akhir:</strong></td>
                <td style="border: none; text-align: right;"><strong>Rp {{ number_format($shiftData->sum('saldo_akhir'), 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>
@endif

<div class="footer">
    <p>© 2025 Pedra Kopi - Sistem POS | Laporan Confidential</p>
</div>

</body>
</html>
