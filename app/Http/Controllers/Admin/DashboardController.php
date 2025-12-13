<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\ShiftKasir;
use App\Models\TotalEarnings;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = now()->format('Y-m-d');

        // 1. Penjualan Hari Ini -> AMBIL DARI saldo_akhir
        $penjualanHariIni = ShiftKasir::whereDate('dibuka_pada', $hariIni)
            ->sum('saldo_akhir') ?? 0;

        // 2. Transaksi Hari Ini
        $transaksiHariIni = Transaksi::whereDate('created_at', $hariIni)
            ->where('status', 'lunas')
            ->count();

        // 3. Stok Kritis
        $stokKritis = Produk::where('stok', '<=', 10)->count();

        // 4. Kasir Aktif
        $kasirAktif = ShiftKasir::where('status', 'buka')
            ->whereDate('dibuka_pada', $hariIni)
            ->distinct('user_id')
            ->count('user_id');

        // 5. Total Produk
        $totalProduk = Produk::count();

        // 6. Void Hari Ini
        $voidHariIni = Transaksi::whereDate('created_at', $hariIni)
            ->where('status', 'void')
            ->count();

        // 7. Penjualan Bulan Ini -> AMBIL DARI saldo_akhir
        $penjualanBulanIni = ShiftKasir::whereYear('dibuka_pada', now()->year)
            ->whereMonth('dibuka_pada', now()->month)
            ->sum('saldo_akhir') ?? 0;

        // 8. Shift Hari Ini
        $shiftHariIni = ShiftKasir::whereDate('dibuka_pada', $hariIni)->count();

        // 9. TOTAL UANG (DARI total_earnings)
        $totalUang = TotalEarnings::sum('saldo_akhir') ?? 0;

        // 10. Grafik 30 hari (tetap dari transaksi)
        $sales = Transaksi::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total) as total')
            )
            ->where('status', 'lunas')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $penjualan30Hari = [];
        for ($i = 29; $i >= 0; $i--) {
            $tanggal = now()->subDays($i)->format('Y-m-d');
            $penjualan30Hari[] = [
                'tanggal' => $tanggal,
                'total'   => isset($sales[$tanggal]) ? (int)$sales[$tanggal] : 0
            ];
        }

        return view('admin.dashboard', compact(
            'penjualanHariIni',
            'transaksiHariIni',
            'stokKritis',
            'kasirAktif',
            'totalProduk',
            'voidHariIni',
            'penjualanBulanIni',
            'shiftHariIni',
            'totalUang',
            'penjualan30Hari'
        ));
    }
}
