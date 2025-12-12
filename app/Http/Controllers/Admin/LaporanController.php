<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\ShiftKasir;
use App\Models\User;
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

    // 🔥 NEW: Show Detail Shift
    public function showShift($id)
    {
        $shift = ShiftKasir::with('user')->findOrFail($id);
        $transaksi = Transaksi::where('shift_kasir_id', $id)->get();
        
        return view('admin.laporan.show', compact('shift', 'transaksi'));
    }

    // 🔥 Export Shift Detail to PDF
    public function exportShiftDetailPdf($id)
    {
        $shift = ShiftKasir::with('user')->findOrFail($id);
        $transaksi = Transaksi::where('shift_kasir_id', $id)->get();

        $pdf = Pdf::loadView('admin.laporan.show-pdf', compact('shift', 'transaksi'))
                    ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-shift-detail-' . $shift->id . '.pdf');
    }

    // 🔥 Export Shift Detail to Excel
    public function exportShiftDetailExcel($id)
    {
        $shift = ShiftKasir::with('user')->findOrFail($id);
        $transaksi = Transaksi::where('shift_kasir_id', $id)->get();

        return Excel::download(
            new \Maatwebsite\Excel\Concerns\WithHeadings,
            'laporan-shift-detail-' . $shift->id . '.xlsx'
        );
    }

    public function laporanShift(Request $request)
    {
        $users = User::where('role', 'kasir')->get();
        
        $shiftData = ShiftKasir::with('user')
            ->orderBy('dibuka_pada', 'desc')
            ->get();

        // Filter by user if selected
        if ($request->user_id) {
            $shiftData = $shiftData->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->from && $request->to) {
            $shiftData = $shiftData->whereBetween('dibuka_pada', [
                $request->from . " 00:00:00",
                $request->to . " 23:59:59"
            ]);
        }

        // Load transaction count and data for each shift
        $shiftData = $shiftData->map(function ($shift) {
            $transaksi = Transaksi::where('shift_kasir_id', $shift->id)->get();
            $shift->transaksi_count = $transaksi->count();
            $shift->transaksi_lunas = $transaksi->where('status', 'lunas')->count();
            $shift->transaksi_void = $transaksi->where('status', 'void')->count();
            $shift->total_transaksi = $transaksi->where('status', 'lunas')->sum('total');
            return $shift;
        });

        return view('admin.laporan.shift', compact('shiftData', 'users'));
    }

    // Export Shift Report to PDF
    public function exportShiftPdf(Request $request)
    {
        $shiftData = ShiftKasir::with('user')
            ->orderBy('dibuka_pada', 'desc')
            ->get();

        if ($request->user_id) {
            $shiftData = $shiftData->where('user_id', $request->user_id);
        }

        if ($request->from && $request->to) {
            $shiftData = $shiftData->whereBetween('dibuka_pada', [
                $request->from . " 00:00:00",
                $request->to . " 23:59:59"
            ]);
        }

        // Load transaction data for each shift
        $shiftData = $shiftData->map(function ($shift) {
            $transaksi = Transaksi::where('shift_kasir_id', $shift->id)->get();
            $shift->transaksi_count = $transaksi->count();
            $shift->transaksi_lunas = $transaksi->where('status', 'lunas')->count();
            $shift->transaksi_void = $transaksi->where('status', 'void')->count();
            $shift->total_transaksi = $transaksi->where('status', 'lunas')->sum('total');
            return $shift;
        });

        if ($shiftData->count() == 0) {
            return back()->with('error', 'Tidak ada data untuk dicetak PDF.');
        }

        $pdf = Pdf::loadView('admin.laporan.shift-pdf', compact('shiftData'))
                    ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-shift-kasir.pdf');
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
