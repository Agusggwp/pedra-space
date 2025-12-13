<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\TotalEarnings;
use Illuminate\Http\Request;

class VoidController extends Controller
{
    /**
     * Menampilkan semua transaksi (bisa digabung dengan laporan)
     */
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'details.produk'])
            ->orderByDesc('created_at')
            ->paginate(25);

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
}