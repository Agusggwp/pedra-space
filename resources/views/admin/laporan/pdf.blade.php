<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 18pt;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10pt;
        }
        th {
            background-color: #f0f0f0;
            padding: 10px 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #333;
        }
        td {
            padding: 8px;
            border: 1px solid #333;
            vertical-align: top;
        }
        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .font-bold   { font-weight: bold; }
        .total-row {
            background-color: #e0e0e0 !important;
            font-weight: bold;
            font-size: 11pt;
        }
        .footer {
            margin-top: 40px;
            font-size: 9pt;
            color: #555;
            display: flex;
            justify-content: space-between;
        }
        @page { margin: 1cm; }
        @media print { body { padding: 0; } }
    </style>
</head>
<body>

    <h2>LAPORAN PENJUALAN</h2>
    <div class="info">
        @if(request()->has('dari') && request()->has('sampai'))
            Periode: {{ \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') }} 
            s/d {{ \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') }}
        @else
            Semua Transaksi
        @endif
        <br>
        Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB
    </div>

    <table>
        <thead>
            <tr>
                <th width="14%">Kode Transaksi</th>
                <th width="20%">Kasir</th>
                <th width="16%">Total</th>
                <th width="16%">Metode Bayar</th>
                <th width="14%">Status</th>
                <th width="20%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $item)
                <tr>
                    <td class="text-center font-bold">
                        {{ 'TRX-' . str_pad($item->id, 6, '0', STR_PAD_LEFT) }}
                    </td>
                    <td>{{ $item->kasir?->name ?? 'Kasir Dihapus' }}</td>
                    <td class="text-right font-bold">
                        Rp {{ number_format($item->total, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        {{ $item->metode_pembayaran ? ucfirst(str_replace('_', ' ', $item->metode_pembayaran)) : '-' }}
                    </td>
                    <td class="text-center">
                        <strong>
                            @if($item->status == 'lunas')
                                <span style="color:green;">Lunas</span>
                            @elseif($item->status == 'pending')
                                <span style="color:orange;">Pending</span>
                            @elseif($item->status == 'batal')
                                <span style="color:red;">Batal</span>
                            @else
                                {{ ucfirst($item->status) }}
                            @endif
                        </strong>
                    </td>
                    <td class="text-center">
                        {{ $item->created_at->format('d/m/Y') }}<br>
                        <small>{{ $item->created_at->format('H:i') }}</small>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding:20px;">
                        <em>Tidak ada data transaksi pada periode ini.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>

        @if($transaksi->isNotEmpty())
        <tfoot>
            <tr class="total-row">
                <td colspan="2" class="text-center font-bold">TOTAL KESELURUHAN</td>
                <td class="text-right font-bold">
                    Rp {{ number_format($transaksi->sum('total'), 0, ',', '.') }}
                </td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
        @endif
    </table>

   

</body>
</html>