<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\ShiftKasir;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = now()->format('Y-m-d');

        $penjualanHariIni = Transaksi::whereDate('created_at', $hariIni)
            ->where('status', 'lunas')
            ->sum('total');

        $transaksiHariIni = Transaksi::whereDate('created_at', $hariIni)
            ->where('status', 'lunas')
            ->count();

        $stokKritis = Produk::where('stok', '<=', 10)->count();

        $kasirAktif = ShiftKasir::where('status', 'buka')
            ->whereDate('dibuka_pada', $hariIni)
            ->distinct('user_id')
            ->count('user_id');

        return view('admin.dashboard', compact(
            'penjualanHariIni',
            'transaksiHariIni',
            'stokKritis',
            'kasirAktif'
        ));
    }
}
