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
use App\Exports\ShiftDetailExport;
use App\Exports\KeuntunganExport;

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
        return Excel::download(new ShiftDetailExport($id), 'laporan-shift-detail-' . $id . '.xlsx');
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

    // 🔥 NEW: Laporan Keuntungan Per Bulan
    public function laporanKeuntungan(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;
        $bulan = $request->bulan ?? now()->month;

        // Ambil semua transaksi detail untuk bulan dan tahun yang dipilih (hanya yang lunas)
        $transaksiDetail = \App\Models\TransaksiDetail::with(['transaksi', 'produk', 'menu'])
            ->whereHas('transaksi', function ($q) use ($tahun, $bulan) {
                $q->whereYear('created_at', $tahun)
                  ->whereMonth('created_at', $bulan)
                  ->where('status', 'lunas');
            })
            ->get();

        // Hitung keuntungan per item
        $keuntungan = $transaksiDetail->map(function ($detail) {
            // Untuk produk
            if ($detail->produk_id) {
                $hargaSatuan = $detail->harga_satuan ?? $detail->harga ?? 0;
                $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
                $hargaBeli = $detail->produk->harga_beli ?? 0;
                $hargaJual = $hargaSatuan;
                
                $detail->keuntungan_per_item = ($hargaJual - $hargaBeli) * $jumlah;
                $detail->tipe = 'produk';
            } 
            // Untuk menu
            else if ($detail->menu_id) {
                $hargaSatuan = $detail->harga_satuan ?? 0;
                $jumlah = $detail->jumlah ?? 0;
                $hargaBeli = $detail->menu->harga_beli ?? 0;
                
                $detail->keuntungan_per_item = ($hargaSatuan - $hargaBeli) * $jumlah;
                $detail->tipe = 'menu';
            }
            
            return $detail;
        });

        // Summary
        $totalPenjualan = $transaksiDetail->sum(function ($detail) {
            $hargaSatuan = $detail->harga_satuan ?? $detail->harga ?? 0;
            $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
            return $hargaSatuan * $jumlah;
        });

        $totalDiskon = $transaksiDetail->sum(function ($detail) {
            $diskonNominal = $detail->diskon_nominal ?? 0;
            $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
            return $diskonNominal * $jumlah;
        });

        $totalHargaBeli = $transaksiDetail->sum(function ($detail) {
            $hargaBeli = 0;
            $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
            
            // Harga beli dari produk
            if ($detail->produk_id) {
                $hargaBeli = $detail->produk->harga_beli ?? 0;
            } 
            // Harga beli dari menu
            else if ($detail->menu_id) {
                $hargaBeli = $detail->menu->harga_beli ?? 0;
            }
            
            return $hargaBeli * $jumlah;
        });

        $totalKeuntungan = $keuntungan->sum('keuntungan_per_item');
        $totalQty = $transaksiDetail->sum(function ($detail) {
            return $detail->jumlah ?? $detail->qty ?? 0;
        });

        // Data untuk grafik (per hari dalam bulan)
        $hariData = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        
        for ($hari = 1; $hari <= $daysInMonth; $hari++) {
            $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari);
            $dayProfit = $transaksiDetail->filter(function ($item) use ($tanggal) {
                return $item->transaksi->created_at->format('Y-m-d') == $tanggal;
            })->sum(function ($detail) {
                if ($detail->produk_id) {
                    $hargaJual = $detail->harga_satuan ?? $detail->harga ?? 0;
                    $hargaBeli = $detail->produk->harga_beli ?? 0;
                    $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
                    return ($hargaJual - $hargaBeli) * $jumlah;
                } else if ($detail->menu_id) {
                    $hargaJual = $detail->harga_satuan ?? 0;
                    $hargaBeli = $detail->menu->harga_beli ?? 0;
                    $jumlah = $detail->jumlah ?? 0;
                    return ($hargaJual - $hargaBeli) * $jumlah;
                }
                return 0;
            });
            
            $hariData[] = [
                'tanggal' => $tanggal,
                'keuntungan' => $dayProfit
            ];
        }

        return view('admin.laporan.keuntungan', compact(
            'keuntungan', 'tahun', 'bulan', 'totalPenjualan', 'totalDiskon',
            'totalHargaBeli', 'totalKeuntungan', 'totalQty', 'hariData'
        ));
    }

    // Export Laporan Keuntungan PDF
    // Export Laporan Keuntungan PDF
    public function exportKeuntunganPdf(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;
        $bulan = $request->bulan ?? now()->month;

        // Ambil semua transaksi detail untuk bulan dan tahun yang dipilih (hanya yang lunas)
        $transaksiDetail = \App\Models\TransaksiDetail::with(['transaksi', 'produk', 'menu'])
            ->whereHas('transaksi', function ($q) use ($tahun, $bulan) {
                $q->whereYear('created_at', $tahun)
                  ->whereMonth('created_at', $bulan)
                  ->where('status', 'lunas');
            })
            ->get();

        // Hitung keuntungan per item
        $keuntungan = $transaksiDetail->map(function ($detail) {
            // Untuk produk
            if ($detail->produk_id) {
                $hargaSatuan = $detail->harga_satuan ?? $detail->harga ?? 0;
                $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
                $hargaBeli = $detail->produk->harga_beli ?? 0;
                $hargaJual = $hargaSatuan;
                $diskonNominal = $detail->diskon_nominal ?? 0;
                
                $detail->diskon_total = $diskonNominal * $jumlah;
                $detail->keuntungan_per_item = ($hargaJual - $hargaBeli) * $jumlah;
                $detail->tipe = 'produk';
            } 
            // Untuk menu
            else if ($detail->menu_id) {
                $hargaSatuan = $detail->harga_satuan ?? 0;
                $jumlah = $detail->jumlah ?? 0;
                $hargaBeli = $detail->menu->harga_beli ?? 0;
                $diskonNominal = $detail->diskon_nominal ?? 0;
                
                $detail->diskon_total = $diskonNominal * $jumlah;
                $detail->keuntungan_per_item = ($hargaSatuan - $hargaBeli) * $jumlah;
                $detail->tipe = 'menu';
            }
            
            return $detail;
        });

        // Summary
        $totalPenjualan = $transaksiDetail->sum(function ($detail) {
            $hargaSatuan = $detail->harga_satuan ?? $detail->harga ?? 0;
            $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
            return $hargaSatuan * $jumlah;
        });

        $totalDiskon = $transaksiDetail->sum(function ($detail) {
            $diskonNominal = $detail->diskon_nominal ?? 0;
            $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
            return $diskonNominal * $jumlah;
        });

        $totalHargaBeli = $transaksiDetail->sum(function ($detail) {
            $hargaBeli = 0;
            $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
            
            // Harga beli dari produk
            if ($detail->produk_id) {
                $hargaBeli = $detail->produk->harga_beli ?? 0;
            } 
            // Harga beli dari menu
            else if ($detail->menu_id) {
                $hargaBeli = $detail->menu->harga_beli ?? 0;
            }
            
            return $hargaBeli * $jumlah;
        });

        $totalKeuntungan = $keuntungan->sum('keuntungan_per_item');
        $totalQty = $transaksiDetail->sum(function ($detail) {
            return $detail->jumlah ?? $detail->qty ?? 0;
        });

        // Data untuk grafik (per hari dalam bulan)
        $hariData = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        
        for ($hari = 1; $hari <= $daysInMonth; $hari++) {
            $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari);
            $dayProfit = $transaksiDetail->filter(function ($item) use ($tanggal) {
                return $item->transaksi->created_at->format('Y-m-d') == $tanggal;
            })->sum(function ($detail) {
                if ($detail->produk_id) {
                    $hargaJual = $detail->harga_satuan ?? $detail->harga ?? 0;
                    $hargaBeli = $detail->produk->harga_beli ?? 0;
                    $jumlah = $detail->jumlah ?? $detail->qty ?? 0;
                    return ($hargaJual - $hargaBeli) * $jumlah;
                } else if ($detail->menu_id) {
                    $hargaJual = $detail->harga_satuan ?? 0;
                    $hargaBeli = $detail->menu->harga_beli ?? 0;
                    $jumlah = $detail->jumlah ?? 0;
                    return ($hargaJual - $hargaBeli) * $jumlah;
                }
                return 0;
            });
            
            $hariData[] = [
                'tanggal' => $tanggal,
                'keuntungan' => $dayProfit
            ];
        }

        $pdf = Pdf::loadView('admin.laporan.keuntungan-pdf', compact(
            'keuntungan', 'tahun', 'bulan', 'totalPenjualan', 'totalDiskon',
            'totalHargaBeli', 'totalKeuntungan', 'totalQty', 'hariData'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-keuntungan-' . $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '.pdf');
    }

    // Export Laporan Keuntungan Excel
    public function exportKeuntunganExcel(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;
        $bulan = $request->bulan ?? now()->month;

        return Excel::download(
            new KeuntunganExport($tahun, $bulan),
            'laporan-keuntungan-' . $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '.xlsx'
        );
    }
}
