<?php

namespace App\Exports;

use App\Models\TransaksiDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KeuntunganExport implements FromCollection, WithHeadings, WithStyles
{
    protected $tahun;
    protected $bulan;

    public function __construct($tahun, $bulan)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function collection()
    {
        $transaksiDetail = TransaksiDetail::with(['transaksi', 'produk', 'menu'])
            ->whereHas('transaksi', function ($q) {
                $q->whereYear('created_at', $this->tahun)
                  ->whereMonth('created_at', $this->bulan)
                  ->where('status', 'lunas');
            })
            ->get();

        return $transaksiDetail->map(function ($detail) {
            $hargaSatuan = $detail->harga_satuan ?? $detail->harga ?? 0;
            $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
            
            if ($detail->produk_id) {
                $hargaBeli = $detail->produk->harga_beli ?? 0;
                $namaItem = $detail->produk->nama ?? 'N/A';
                $tipe = 'Produk';
            } else {
                $hargaBeli = $detail->menu->harga_beli ?? 0;
                $namaItem = $detail->menu->nama ?? 'N/A';
                $tipe = 'Menu';
            }

            $totalBeli = $hargaBeli * $jumlah;
            $totalJual = $hargaSatuan * $jumlah;
            $keuntungan = $totalJual - $totalBeli;

            return [
                'Tipe' => $tipe,
                'Nama Item' => $namaItem,
                'Qty' => $jumlah,
                'Harga Beli' => $hargaBeli,
                'Harga Jual' => $hargaSatuan,
                'Total Beli' => $totalBeli,
                'Total Jual' => $totalJual,
                'Keuntungan' => $keuntungan,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tipe',
            'Nama Item',
            'Qty',
            'Harga Beli',
            'Harga Jual',
            'Total Beli',
            'Total Jual',
            'Keuntungan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '000000']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
