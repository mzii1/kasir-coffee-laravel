<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filter transaksi (bisa dipakai nanti untuk laporan)
        $query = Transaksi::query();

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        // Ambil data transaksi & menu
        $transaksis = $query->with('details.menu')->orderBy('created_at', 'desc')->get();
        $menu = Menu::all();

        return view('transaksi.index', [
            'menu' => $menu,
            'keranjang' => session('keranjang', []),
            'total' => session('total', 0),
            'transaksis' => $transaksis,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $menus = Menu::all();
        return view('transaksi.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $keranjang = session('keranjang', []);
        $total = session('total', 0);

        if (empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $transaksi = Transaksi::create([
            'tanggal' => now(),
            'total' => $total,
            'metode_pembayaran' => $request->metode ?? 'cash',
        ]);

        foreach ($keranjang as $menu_id => $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'menu_id' => $menu_id,
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        session()->forget(['keranjang', 'total']);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }

    public function filterTransaksi(Request $request)
    {
        $query = Transaksi::with('details.menu');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function exportPdf(Request $request)
    {
        $transaksi = $this->filterTransaksi($request);
        $pdf = Pdf::loadView('transaksi.export-pdf', compact('transaksi'));

        return $pdf->download('laporan-transaksi.pdf');
    }

    public function tambahKeranjang(Request $request)
    {
        $menu = Menu::findOrFail($request->menu_id);

        // Ambil keranjang dari session, atau buat baru
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$menu->id])) {
            $keranjang[$menu->id]['jumlah']+= 1;
            $keranjang[$menu->id]['subtotal'] = $keranjang[$menu->id]['jumlah']* $menu->harga;
        } else {
            $keranjang[$menu->id] = [
                'id' => $menu->id,
                'nama' => $menu->nama,
                'harga' => $menu->harga,
                'jumlah' => 1,
                'subtotal' => $menu->harga,
            ];
        }

        // Hitung ulang Total
        $total = array_sum(array_column($keranjang, 'subtotal'));

        // Simpan kembali ke session
        session([
            'keranjang' => $keranjang,
            'total' => $total,
        ]);

        return redirect()->back()->with('success', 'item ditambahkan');
    }

    public function hapusKeranjang($id)
    {
        $keranjang = session()->get('keranjang', []);

        // Hapus item dari keranjang
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
        }

        // Hitung ulang total
        $total = array_sum(array_column($keranjang, 'subtotal'));

        // Simpan ke session lagi
        session([
            'keranjang' => $keranjang,
            'total' => $total,
        ]);

        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function updateKeranjang(Request $request, $id)
    {
        $keranjang = session()->get('keranjang', []);

        if (!isset($keranjang[$id])) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
        }

        // Update jumlah sesuai aksi (+ atau -)
        if ($request->aksi == 'tambah') {
            $keranjang[$id]['jumlah'] += 1;
        } elseif ($request->aksi == 'kurang') {
            $keranjang[$id]['jumlah'] -= 1;

            // Jika jumlah jadi 0, hapus item
            if ($keranjang[$id]['jumlah'] <= 0) {
                unset($keranjang[$id]);
            }
        }

        // Hitung ulang subtotal dan total
        if (isset($keranjang[$id])) {
            $keranjang[$id]['subtotal'] = $keranjang[$id]['jumlah'] * $keranjang[$id]['harga'];
        }

        $total = array_sum(array_column($keranjang, 'subtotal'));

        session([
            'keranjang' => $keranjang,
            'total' => $total,
        ]);

        return redirect()->back()->with('success', 'Jumlah item diperbarui.');
    }

    public function cetakStruk($id){
        $transaksi = Transaksi::with('items.menu')->findOrFail($id);

        $pdf = Pdf::loadView('transaksi.struk', compact('transaksi'))->setPaper([0, 0, 226.77, 600], 'potrait');
        return $pdf->stream('struk_transaksi.pdf');
    }




}
