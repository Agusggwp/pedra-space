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
        @foreach($transaksi as $item)
        <tr>
            <td>{{ 'TRX-' . str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</td>
            <td>{{ $item->kasir->name ?? '-' }}</td>
            <td>{{ $item->total }}</td>
            <td>{{ $item->metode_pembayaran }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ $item->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
