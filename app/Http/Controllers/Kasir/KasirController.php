<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\ShiftKasir;
use App\Models\TotalEarnings;
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
        $menus = Menu::where('is_active', true)->with('options')->orderBy('nama')->get();
        $keranjang = session('keranjang', []);

        return view('kasir.pos', compact('produks', 'menus', 'keranjang', 'shift'));
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

    // TUTUP KASIR — HANYA HITUNG DARI SHIFT YANG SEDANG BUKA!
    public function tutupKasirForm()
    {
        $shift = ShiftKasir::buka()->where('user_id', auth()->id())->first();
        if (!$shift) {
            return redirect()->route('kasir.pos')->with('error', 'Kasir belum dibuka!');
        }

        // 🔥 PISAHKAN BERDASARKAN METODE PEMBAYARAN
        $transaksiTunai = Transaksi::where('user_id', auth()->id())
            ->where('metode_pembayaran', 'Tunai')
            ->where('created_at', '>=', $shift->dibuka_pada)
            ->sum('total');

        $transaksiEDC = Transaksi::where('user_id', auth()->id())
            ->where('metode_pembayaran', 'EDC')
            ->where('created_at', '>=', $shift->dibuka_pada)
            ->sum('total');

        $transaksiQRIS = Transaksi::where('user_id', auth()->id())
            ->where('metode_pembayaran', 'QRIS')
            ->where('created_at', '>=', $shift->dibuka_pada)
            ->sum('total');

        $transaksiTransfer = Transaksi::where('user_id', auth()->id())
            ->where('metode_pembayaran', 'Transfer')
            ->where('created_at', '>=', $shift->dibuka_pada)
            ->sum('total');

        $transaksiTunaiEDC = $transaksiTunai + $transaksiEDC;

        return view('kasir.tutup', compact(
            'shift', 
            'transaksiTunaiEDC', 
            'transaksiTunai', 
            'transaksiEDC', 
            'transaksiQRIS', 
            'transaksiTransfer'
        ));
    }

    public function tutupKasir(Request $request)
    {
        $shift = ShiftKasir::buka()->where('user_id', auth()->id())->firstOrFail();
        $request->validate(['saldo_akhir' => 'required|numeric|min:0']);

        $transaksiTunaiEDC = Transaksi::where('user_id', auth()->id())
            ->whereIn('metode_pembayaran', ['Tunai', 'EDC'])
            ->where('created_at', '>=', $shift->dibuka_pada)
            ->sum('total');

        $harusnyaAda = $shift->saldo_awal + $transaksiTunaiEDC;
        $selisih = $request->saldo_akhir - $harusnyaAda;

        $shift->update([
            'saldo_akhir' => $request->saldo_akhir,
            'selisih' => $selisih,
            'ditutup_pada' => now(),
            'status' => 'tutup'
        ]);

        // 🔥 OTOMATIS SIMPAN KE TOTAL_EARNINGS
        TotalEarnings::create([
            'user_id' => auth()->id(),
            'saldo_akhir' => $request->saldo_akhir,
            'keterangan' => 'Penutupan kasir - Selisih: Rp ' . number_format($selisih)
        ]);

        session()->forget('keranjang');

        return redirect()->route('kasir.dashboard')
            ->with('success', "Kasir ditutup! Selisih: Rp " . number_format($selisih));
    }

    // DAFTAR PENJUALAN — HANYA DARI SHIFT YANG SEDANG BUKA!
    public function daftarPenjualan()
    {
        $shift = ShiftKasir::buka()->where('user_id', auth()->id())->first();

        $transaksis = Transaksi::with('details.produk')
            ->where('user_id', auth()->id())
            ->whereIn('metode_pembayaran', ['Tunai', 'QRIS', 'EDC'])
            ->when($shift, fn($q) => $q->where('created_at', '>=', $shift->dibuka_pada))
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

    // TAMBAH MENU KE KERANJANG DENGAN OPTIONS
    public function tambahMenuKeKeranjang(Request $request)
    {
        $menu = Menu::findOrFail($request->menu_id);
        $keranjang = session('keranjang', []);

        // Hitung harga total: harga_base + tambahan dari options
        $totalTambahan = 0;
        $selectedOptions = [];
        
        if ($request->has('options')) {
            foreach ($request->options as $tipe => $optionId) {
                if ($optionId) {
                    $option = \App\Models\MenuOption::find($optionId);
                    if ($option) {
                        $totalTambahan += $option->nilai;
                        $selectedOptions[$tipe] = $option->nama_option;
                    }
                }
            }
        }

        $hargaFinal = $menu->harga_base + $totalTambahan;
        $jumlah = $request->jumlah ?? 1;

        // Key unik berdasarkan menu_id + options combo
        $optionHash = md5(json_encode($selectedOptions));
        $key = 'menu_' . $menu->id . '_' . $optionHash;

        if (isset($keranjang[$key])) {
            $keranjang[$key]['jumlah'] += $jumlah;
        } else {
            $keranjang[$key] = [
                'type' => 'menu',
                'menu_id' => $menu->id,
                'nama' => $menu->nama,
                'harga' => $hargaFinal,
                'jumlah' => $jumlah,
                'options' => $selectedOptions,
                'harga_base' => $menu->harga_base,
                'tambahan' => $totalTambahan
            ];
        }

        session(['keranjang' => $keranjang]);
        return back()->with('success', $menu->nama . ' ditambahkan!');
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

        // 🔥 VALIDASI STOK HANYA UNTUK PRODUK (BUKAN MENU)
        $stokError = null;
        foreach ($keranjang as $id => $item) {
            // Skip validasi untuk menu items
            if (isset($item['type']) && $item['type'] === 'menu') {
                continue;
            }

            $produk = Produk::find($id);
            if (!$produk) {
                $stokError = "Produk tidak ditemukan!";
                break;
            }
            if ($produk->stok < $item['jumlah']) {
                $stokError = "Stok {$produk->nama} tidak cukup! (Tersedia: {$produk->stok}, Diminta: {$item['jumlah']})";
                break;
            }
        }

        if ($stokError) {
            return back()->with('error', $stokError);
        }

        $shift = ShiftKasir::buka()->where('user_id', auth()->id())->firstOrFail();
        $total = collect($keranjang)->sum(fn($i) => $i['harga'] * $i['jumlah']);

        $transaksi = Transaksi::create([
            'user_id' => auth()->id(),
            'shift_kasir_id' => $shift->id,
            'metode_pembayaran' => $request->metode,
            'total' => $total,
            'bayar' => $request->bayar,
            'kembalian' => $request->bayar - $total,
            'nama_pelanggan' => $request->nama_pelanggan,
            'nomor_meja' => $request->nomor_meja,
            'status' => 'lunas'
        ]);

        foreach ($keranjang as $id => $item) {
            // Untuk produk: simpan produk_id dan kurangi stok
            if (!isset($item['type']) || $item['type'] !== 'menu') {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['jumlah']
                ]);
                Produk::find($id)->decrement('stok', $item['jumlah']);
            } else {
                // Untuk menu: simpan menu_id tanpa kurangi stok
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $item['menu_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['jumlah'],
                    'options' => $item['options'] ?? null
                ]);
            }
        }

        session()->forget('keranjang');
        return redirect()->route('kasir.cetak', $transaksi->id);
    }

    public function cetak($id)
    {
        $transaksi = Transaksi::with('details.produk')->findOrFail($id);
        return view('kasir.cetak', compact('transaksi'));
    }



    // TAMPILKAN FORM UPDATE STOK
public function updateStokForm()
{
    $produks = Produk::orderBy('nama')->get();
    return view('kasir.update-stok', compact('produks'));
}

// PROSES TAMBAH / KURANG STOK
public function updateStokProses(Request $request)
{
    $request->validate([
        'produk_id' => 'required|exists:produks,id',
        'jumlah' => 'required|integer|min:-9999|max:9999|not_in:0',
        'keterangan' => 'nullable|string|max:255'
    ]);

    $produk = Produk::findOrFail($request->produk_id);
    $jumlah = (int)$request->jumlah;

    if ($jumlah < 0 && abs($jumlah) > $produk->stok) {
        return back()->with('error', 'Stok tidak cukup untuk dikurangi!');
    }

    $produk->increment('stok', $jumlah);

    // Catat ke riwayat stok (opsional, pakai tabel stok_histories kalau ada)
    // StokHistory::create([...]);

    $tipe = $jumlah > 0 ? 'ditambah' : 'dikurangi';
    $pesan = "Stok {$produk->nama} berhasil {$tipe} sebanyak " . abs($jumlah) . " (Total stok: {$produk->stok})";

    return back()->with('success', $pesan);
}
}