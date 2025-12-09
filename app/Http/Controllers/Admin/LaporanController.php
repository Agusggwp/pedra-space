<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $transaksi = $this->filterData($request);

        return view('admin.laporan.index', compact('transaksi'));
    }

    public function exportPdf(Request $request)
    {
        $transaksi = $this->filterData($request);

        if ($transaksi->count() == 0) {
            return back()->with('error', 'Tidak ada data untuk dicetak PDF.');
        }

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('transaksi'))
                    ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-penjualan.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new TransaksiExport($request), 'laporan-penjualan.xlsx');
    }

    private function filterData($request)
    {
        $query = Transaksi::with('kasir')->orderBy('created_at', 'desc');

        // FILTER HARI / BULAN / TAHUN
        if ($request->filter == 'hari') {
            $query->whereDate('created_at', today());
        } 
        elseif ($request->filter == 'bulan') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } 
        elseif ($request->filter == 'tahun') {
            $query->whereYear('created_at', now()->year);
        }

        // FILTER RANGE TANGGAL (FIX)
        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [
                $request->from . " 00:00:00",
                $request->to . " 23:59:59"
            ]);
        }

        return $query->get();
    }
}
