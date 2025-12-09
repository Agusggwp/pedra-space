<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
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

        return back()->with('success', "Transaksi #{$transaksi->id} berhasil DIBATALKAN & stok dikembalikan!");
    }
}