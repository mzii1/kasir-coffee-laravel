<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        //Mengambil data ringkasan
        $totalTransaksi = Transaksi::count();
        $totalMenu = Menu::count();
        $transaksiHariIni = Transaksi::whereDate('tanggal', Carbon::today())->count();
        $totalUser = User::count();

        //data grafik penjualan
        $penjualan = Transaksi::select(
            DB::raw("DATE(tanggal) as tanggal"),
            DB::raw("SUM(total) as total")
        )->groupBy('tanggal')->orderBy('tanggal', 'ASC')->get();

        //kirim ke view dashboard
        return view('dashboard.index', [
            'totalTransaksi' => $totalTransaksi,
            'totalMenu' => $totalMenu,
            'transaksiHariIni' => $transaksiHariIni,
            'totalUser' => $totalUser,
            'penjualan' => $penjualan
        ]);
    }
}
