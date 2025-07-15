<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Svg\Tag\Rect;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $transaksis = [];

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')){
            $transaksis = Transaksi::whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ])->get();
        }

        return view('laporan.index', [
            'transaksis' => $transaksis,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $query = Transaksi::with('details.menu');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')){
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $transaksis = $query->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('transaksis'));
        return $pdf->download('laporan-transaksi.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tanggalAwal = request('tanggal_awal');
        $tanggalAkhir = request('tanggal_akhir');

        $transaksis = Transaksi::with('details.menu')->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir){
            $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        })->get();

        //membangun isi CSV
        $csvData = "Tanggal,Metode Pembayaran,Total,Detail Produk\n";

        foreach ($transaksis as $transaksi) {
            $detailProduk = $transaksi->details->map(function ($item) {
                return "{$item->menu->nama} ({$item->jumlah}x Rp" . number_format($item->harga_satuan, 0, ',', '.') . ")";
            })->join('; ');

            $csvData .= "{$transaksi->tanggal},{$transaksi->metode_pembayaran},{$transaksi->total},\"{$detailProduk}\"\n";
        }

        // Return CSV sebagai file download
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-transaksi.csv"',
            'Cache-Control' => 'no-store, no-cache',
        ]);

    }
}
