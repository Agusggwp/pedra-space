<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = Transaksi::with('kasir')->orderBy('created_at', 'desc');

        // Filter Hari / Bulan / Tahun
        if ($this->request->filter == 'hari') {
            $query->whereDate('created_at', today());
        } elseif ($this->request->filter == 'bulan') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($this->request->filter == 'tahun') {
            $query->whereYear('created_at', now()->year);
        }

        // Filter Range Tanggal
        if ($this->request->from && $this->request->to) {
            $query->whereBetween('created_at', [
                $this->request->from . ' 00:00:00',
                $this->request->to . ' 23:59:59'
            ]);
        }

        return view('admin.laporan.excel', [
            'transaksi' => $query->get()
        ]);
    }
}
