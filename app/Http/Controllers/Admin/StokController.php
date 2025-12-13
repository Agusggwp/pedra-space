<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\StokHistory;
use App\Models\TotalEarnings;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // 1. Dashboard Stok
    public function index()
    {
        $produks = Produk::with('category')
            ->orderByRaw('stok = 0')
            ->orderBy('stok')
            ->orderBy('nama')
            ->get();

        return view('admin.stok.index', compact('produks'));
    }

    // 2. Form Stok Masuk
    public function masuk()
    {
        $produks = Produk::orderBy('nama')->get();
        return view('admin.stok.masuk', compact('produks'));
    }

    public function storeMasuk(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah'    => 'required|integer|min:1',
            'keterangan'=> 'nullable|string|max:255'
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $produk->increment('stok', $request->jumlah);

        // Hitung pengeluaran: harga_beli * jumlah
        $pengeluaran = $produk->harga_beli * $request->jumlah;

        StokHistory::create([
            'produk_id'   => $produk->id,
            'tipe'        => 'masuk',
            'jumlah'      => $request->jumlah,
            'biaya'       => $pengeluaran,
            'keterangan'  => $request->keterangan,
            'user_id'     => auth()->id()
        ]);

        // 🔥 CATAT KE TOTAL_EARNINGS SEBAGAI PENGELUARAN (NILAI NEGATIF)
        TotalEarnings::create([
            'user_id' => auth()->id(),
            'saldo_akhir' => -$pengeluaran,
            'keterangan' => "Pembelian stok {$produk->nama} - {$request->jumlah} unit @ Rp " . number_format($produk->harga_beli)
        ]);

        return redirect()->route('admin.stok.index')
            ->with('success', "Stok {$produk->nama} +{$request->jumlah} (Total: {$produk->stok}). Pengeluaran: Rp " . number_format($pengeluaran));
    }

    // 3. Form Stok Keluar
    public function keluar()
    {
        $produks = Produk::where('stok', '>', 0)->orderBy('nama')->get();
        return view('admin.stok.keluar', compact('produks'));
    }

    public function storeKeluar(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah'    => 'required|integer|min:1',
            'keterangan'=> 'nullable|string|max:255'
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak cukup! Tersedia: ' . $produk->stok);
        }

        $produk->decrement('stok', $request->jumlah);

        StokHistory::create([
            'produk_id'   => $produk->id,
            'tipe'        => 'keluar',
            'jumlah'      => $request->jumlah,
            'keterangan'  => $request->keterangan,
            'user_id'     => auth()->id()
        ]);

        return redirect()->route('admin.stok.index')
            ->with('success', "Stok {$produk->nama} -{$request->jumlah} (Sisa: {$produk->stok})");
    }

    // 4. Riwayat Stok
    public function riwayat(Request $request)
    {
        $query = StokHistory::with(['produk', 'user']);

        // Filter by month
        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter by year
        $tahun = $request->tahun ?? now()->year;
        $query->whereYear('created_at', $tahun);

        $histories = $query->orderByDesc('created_at')
            ->paginate(25);

        return view('admin.stok.riwayat', compact('histories', 'tahun'));
    }

    // Export Stok History to PDF
    public function exportRiwayatPdf(Request $request)
    {
        $query = StokHistory::with(['produk', 'user']);

        // Filter by month
        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter by year
        $tahun = $request->tahun ?? now()->year;
        $query->whereYear('created_at', $tahun);

        $histories = $query->orderByDesc('created_at')->get();

        if ($histories->count() == 0) {
            return back()->with('error', 'Tidak ada data riwayat stok untuk periode ini.');
        }

        $bulan = $request->bulan ?? now()->month;
        $namabulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$bulan];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.stok.riwayat-pdf', compact('histories', 'tahun', 'bulan', 'namabulan'))
                    ->setPaper('a4', 'landscape');

        return $pdf->download('riwayat-stok-' . $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '.pdf');
    }
}