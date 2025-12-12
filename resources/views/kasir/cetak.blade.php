<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk #{{ $transaksi->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 10px; font-size: 12px; }
        .struk { width: 80mm; margin: 0 auto; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .line { border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 3px 0; }
        .bold { font-weight: bold; }
        @media print {
            body { margin: 0; padding: 5mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print(); window.onafterprint = function(){ window.close(); }">

<div class="struk">
    <div class="text-center">
        <h2 style="margin:0; padding:0;"><P>PEDRA SPACE</P></h2>
        <p style="margin:5px 0;">Jl. Raya Bilukan<br>Telp: 0812-3456-7890</p>
    </div>
    <div class="line"></div>

    <table>
        <tr>
            <td>No. Struk</td>
            <td class="text-right">#{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="text-right">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td class="text-right">{{ auth()->user()->name }}</td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td class="text-right">{{ $transaksi->nama_pelanggan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Meja</td>
            <td class="text-right">{{ $transaksi->nomor_meja ?? '-' }}</td>
        </tr>
    </table>

    <div class="line"></div>

    @foreach($transaksi->details as $d)
    <table>
        <tr>
            <td colspan="3">{{ $d->produk->nama }}</td>
        </tr>
        <tr>
            <td>{{ $d->jumlah }} × Rp {{ number_format($d->harga_satuan) }}</td>
            <td></td>
            <td class="text-right">Rp {{ number_format($d->subtotal) }}</td>
        </tr>
    </table>
    @endforeach

    <div class="line"></div>

    <table>
        <tr class="bold">
            <td>TOTAL</td>
            <td class="text-right">Rp {{ number_format($transaksi->total) }}</td>
        </tr>
        <tr>
            <td>Bayar ({{ $transaksi->metode_pembayaran }})</td>
            <td class="text-right">Rp {{ number_format($transaksi->bayar) }}</td>
        </tr>
        <tr class="bold">
            <td>Kembalian</td>
            <td class="text-right">Rp {{ number_format($transaksi->kembalian) }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="text-center">
        <p style="margin:5px 0;"><strong>TERIMA KASIH</strong><br>Semoga Berkah & Selalu Sehat!</p>
        <small>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</small>
    </div>
</div>

<!-- Tombol Kembali (hanya muncul di layar, tidak tercetak) -->
<div class="no-print text-center mt-4">
    <a href="{{ route('kasir.pos') }}" class="btn btn-primary btn-lg">
        Kembali ke POS
    </a>
</div>

</body>
</html>