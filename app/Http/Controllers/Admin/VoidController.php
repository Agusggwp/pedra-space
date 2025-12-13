<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\TotalEarnings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoidController extends Controller
{
    /**
     * Menampilkan semua transaksi (bisa digabung dengan laporan)
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'details.produk', 'voidBy']);

        // Filter by month
        if ($request->bulan) {
            $query->whereMonth(DB::raw('COALESCE(void_at, created_at)'), $request->bulan);
        }

        // Filter by year
        $tahun = $request->tahun ?? now()->year;
        $query->whereYear(DB::raw('COALESCE(void_at, created_at)'), $tahun);

        $transaksis = $query->orderByDesc('created_at')->paginate(25);

        return view('admin.void.index', compact('transaksis'));
    }

    /**
     * Proses Void / Refund / Batalkan Transaksi
     */
    public function prosesVoid(Request $request, Transaksi $transaksi)
    {
        // Cek apakah sudah pernah di-void
        if ($transaksi->status === 'void') {
            return back()->with('error', 'Transaksi ini sudah dibatalkan sebelumnya!');
        }

        // Validasi alasan void
        $request->validate([
            'keterangan' => 'required|string|max:500'
        ]);

        // Kembalikan stok semua item
        foreach ($transaksi->details as $detail) {
            $detail->produk->increment('stok', $detail->jumlah);
        }

        // Update status transaksi
        $transaksi->update([
            'status'           => 'void',
            'keterangan_void'  => $request->keterangan,
            'void_at'          => now(),
            'void_by'          => auth()->id(),
        ]);

        // 🔥 CATAT KE TOTAL_EARNINGS SEBAGAI REFUND (NILAI NEGATIF)
        TotalEarnings::create([
            'user_id' => auth()->id(),
            'saldo_akhir' => -$transaksi->total,
            'keterangan' => "Refund/Void Transaksi #{$transaksi->id} - Rp " . number_format($transaksi->total) . " | Alasan: {$request->keterangan}"
        ]);

        return back()->with('success', "Transaksi #{$transaksi->id} berhasil DIBATALKAN, stok dikembalikan, & refund Rp " . number_format($transaksi->total) . " dicatat!");
    }

    /**
     * Export Transaksi yang Dibatalkan (Void) ke PDF
     */
    public function exportVoidPdf(Request $request)
    {
        $query = Transaksi::with(['user', 'details.produk', 'voidBy'])
            ->where('status', 'void');

        // Filter by month jika ada
        if ($request->bulan) {
            $query->whereMonth('void_at', $request->bulan);
        }

        // Filter by year
        $tahun = $request->tahun ?? now()->year;
        $query->whereYear('void_at', $tahun);

        $transaksis = $query->orderByDesc('void_at')->get();

        if ($transaksis->count() == 0) {
            return back()->with('error', 'Tidak ada transaksi yang dibatalkan untuk periode ini.');
        }

        $bulan = $request->bulan ?? now()->month;
        $namabulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$bulan];

        $totalVoid = $transaksis->sum('total');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.void.void-pdf', compact('transaksis', 'tahun', 'bulan', 'namabulan', 'totalVoid'))
                    ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-void-' . $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '.pdf');
    }
}