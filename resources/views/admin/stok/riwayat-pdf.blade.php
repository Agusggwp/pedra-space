<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Stok</title>
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
        }
        td {
            padding: 6px 8px;
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
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 10px;
        }
        .badge-masuk {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .badge-keluar {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

<div class="header-info">
    <h1>LAPORAN RIWAYAT STOK</h1>
    @if($bulan)
        <p><strong>Periode:</strong> {{ $namabulan }} {{ $tahun }}</p>
    @else
        <p><strong>Periode:</strong> Tahun {{ $tahun }}</p>
    @endif
    <p><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y H:i') }}</p>
</div>

@if($histories->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 15%">Produk</th>
                <th style="width: 8%">Kode</th>
                <th style="width: 8%" class="text-center">Tipe</th>
                <th style="width: 8%" class="text-right">Jumlah</th>
                <th style="width: 14%" class="text-right">Biaya</th>
                <th style="width: 20%">Keterangan</th>
                <th style="width: 15%">User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $h)
            <tr>
                <td>{{ $h->created_at->format('d/m/Y H:i') }}</td>
                <td><strong>{{ $h->produk->nama }}</strong></td>
                <td>{{ $h->produk->kode }}</td>
                <td class="text-center">
                    @if($h->tipe == 'masuk')
                        <span class="badge badge-masuk">Masuk</span>
                    @else
                        <span class="badge badge-keluar">Keluar</span>
                    @endif
                </td>
                <td class="text-right"><strong>{{ $h->jumlah }}</strong></td>
                <td class="text-right">
                    @if($h->biaya)
                        Rp {{ number_format($h->biaya, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $h->keterangan ?: '-' }}</td>
                <td>{{ $h->user->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; padding: 10px; background-color: #f0f0f0; border-radius: 3px;">
        <p><strong>Total Riwayat:</strong> {{ $histories->count() }} transaksi</p>
        <p><strong>Total Biaya (Masuk):</strong> Rp {{ number_format($histories->where('tipe', 'masuk')->sum('biaya'), 0, ',', '.') }}</p>
    </div>
@else
    <div style="text-align: center; padding: 40px; color: #999;">
        <p style="font-size: 14px;">Tidak ada data riwayat stok untuk periode ini</p>
    </div>
@endif

<div class="footer">
    <p>© 2025 Pedra Kopi - Sistem POS | Laporan Confidential</p>
</div>

</body>
</html>
