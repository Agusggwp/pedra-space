<?php

namespace App\Exports;

use App\Models\ShiftKasir;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ShiftDetailExport implements FromCollection, WithHeadings, WithStyles
{
    protected $shiftId;

    public function __construct($shiftId)
    {
        $this->shiftId = $shiftId;
    }

    public function collection()
    {
        $shift = ShiftKasir::with('user')->findOrFail($this->shiftId);
        $transaksi = Transaksi::where('shift_kasir_id', $this->shiftId)
            ->with('kasir')
            ->get();

        return $transaksi->map(function ($t) {
            return [
                'ID Transaksi' => $t->id,
                'Tanggal' => $t->created_at->format('d-m-Y H:i:s'),
                'Kasir' => $t->kasir->name ?? '-',
                'Total' => 'Rp ' . number_format($t->total, 0, ',', '.'),
                'Status' => strtoupper($t->status),
                'Pelanggan' => $t->pelanggan ?? '-',
                'Meja' => $t->meja ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal',
            'Kasir',
            'Total',
            'Status',
            'Pelanggan',
            'Meja',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '000000']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
