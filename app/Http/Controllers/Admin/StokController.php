<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\StokHistory;
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

        StokHistory::create([
            'produk_id'   => $produk->id,
            'tipe'        => 'masuk',
            'jumlah'      => $request->jumlah,
            'keterangan'  => $request->keterangan,
            'user_id'     => auth()->id()
        ]);

        return redirect()->route('admin.stok.index')
            ->with('success', "Stok {$produk->nama} +{$request->jumlah} (Total: {$produk->stok})");
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
    public function riwayat()
    {
        $histories = StokHistory::with(['produk', 'user'])
            ->orderByDesc('created_at')
            ->paginate(25);

        return view('admin.stok.riwayat', compact('histories'));
    }
}