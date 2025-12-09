<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\ShiftKasir;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    // POS UTAMA
    public function index()
    {
        $shift = ShiftKasir::buka()->where('user_id', auth()->id())->first();
        if (!$shift) {
            return redirect()->route('kasir.buka');
        }

        $produks = Produk::where('stok', '>', 0)->orderBy('nama')->get();
        $keranjang = session('keranjang', []);

        return view('kasir.pos', compact('produks', 'keranjang', 'shift'));
    }

    // BUKA KASIR
    public function bukaKasirForm()
    {
        if (ShiftKasir::buka()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('kasir.pos');
        }
        return view('kasir.buka');
    }

    public function bukaKasir(Request $request)
    {
        $request->validate(['saldo_awal' => 'required|numeric|min:0']);

        ShiftKasir::create([
            'user_id' => auth()->id(),
            'saldo_awal' => $request->saldo_awal,
            'status' => 'buka'
        ]);

        return redirect()->route('kasir.pos')->with('success', 'Kasir berhasil dibuka!');
    }

    // TUTUP KASIR (SUDAH DIPERBAIKI TOTAL!)
    public function tutupKasirForm()
    {
        $shift = ShiftKasir::buka()->where('user_id', auth()->id())->first();
        if (!$shift) {
            return redirect()->route('kasir.pos')->with('error', 'Kasir belum dibuka!');
        }

        $transaksiTunaiEDC = Transaksi::where('user_id', auth()->id())
            ->whereIn('metode_pembayaran', ['Tunai', 'EDC'])
            ->whereDate('created_at', today())
            ->sum('total');

        return view('kasir.tutup', compact('shift', 'transaksiTunaiEDC'));
    }

    public function tutupKasir(Request $request)
    {
        $shift = ShiftKasir::buka()->where('user_id', auth()->id())->firstOrFail();
        $request->validate(['saldo_akhir' => 'required|numeric|min:0']);

        $transaksiTunaiEDC = Transaksi::where('user_id', auth()->id())
            ->whereIn('metode_pembayaran', ['Tunai', 'EDC'])
            ->whereDate('created_at', today())
            ->sum('total');

        $harusnyaAda = $shift->saldo_awal + $transaksiTunaiEDC;
        $selisih = $request->saldo_akhir - $harusnyaAda;

        $shift->update([
            'saldo_akhir' => $request->saldo_akhir,
            'selisih' => $selisih,
            'ditutup_pada' => now(),
            'status' => 'tutup'
        ]);

        session()->forget('keranjang');

        return redirect()->route('kasir.dashboard')
            ->with('success', "Kasir ditutup! Selisih: Rp " . number_format($selisih));
    }

    // DAFTAR PENJUALAN HARI INI
    public function daftarPenjualan()
    {
        $transaksis = Transaksi::with('details.produk')
            ->where('user_id', auth()->id())
            ->whereIn('metode_pembayaran', ['Tunai', 'EDC'])
            ->whereDate('created_at', today())
            ->latest()
            ->get();

        return view('kasir.daftar', compact('transaksis'));
    }

    // TAMBAH & HAPUS KERANJANG
    public function tambahKeKeranjang(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);
        $keranjang = session('keranjang', []);

        if (isset($keranjang[$produk->id])) {
            $keranjang[$produk->id]['jumlah']++;
        } else {
            $keranjang[$produk->id] = [
                'nama' => $produk->nama,
                'harga' => $produk->harga_jual,
                'jumlah' => 1
            ];
        }

        session(['keranjang' => $keranjang]);
        return back()->with('success', $produk->nama . ' ditambahkan!');
    }

    public function hapusDariKeranjang($id)
    {
        $keranjang = session('keranjang', []);
        unset($keranjang[$id]);
        session(['keranjang' => $keranjang]);
        return back();
    }

    // BAYAR & CETAK STRUK
    public function bayar(Request $request)
    {
        $keranjang = session('keranjang', []);
        if (empty($keranjang)) return back()->with('error', 'Keranjang kosong!');

        $total = collect($keranjang)->sum(fn($i) => $i['harga'] * $i['jumlah']);

        $transaksi = Transaksi::create([
            'user_id' => auth()->id(),
            'metode_pembayaran' => $request->metode,
            'total' => $total,
            'bayar' => $request->bayar,
            'kembalian' => $request->bayar - $total,
        ]);

        foreach ($keranjang as $id => $item) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $id,
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga'],
                'subtotal' => $item['harga'] * $item['jumlah']
            ]);
            Produk::find($id)->decrement('stok', $item['jumlah']);
        }

        session()->forget('keranjang');
        return redirect()->route('kasir.cetak', $transaksi->id);
    }

    public function cetak($id)
    {
        $transaksi = Transaksi::with('details.produk')->findOrFail($id);
        return view('kasir.cetak', compact('transaksi'));
    }
}