<?php

namespace App\Livewire;

use App\Models\DetailTransaksi;
use Livewire\Component;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;

class CheckOutPage extends Component
{
    public $keranjang = [];
    public $total = 0;
    public $metodePembayaran = '';

    public function mount()
    {
        $this->keranjang = session('keranjang', []);
        $this->total = session('total', 0);
    }

    public function konfirmasiPembayaran()
    {
        if ($this->metodePembayaran === '') {
            session()->flash('message', 'Silakan pilih metode pembayaran.');
            return;
        }

        if (empty($this->keranjang)) {
            session()->flash('message', 'Keranjang masih kosong.');
            return;
        }

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'tanggal' => now(),
                'metode' => strtoupper($this->metodePembayaran),
                'total' => $this->total,
            ]);

            foreach ($this->keranjang as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $item['id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            // Bersihkan session
            session()->forget(['keranjang', 'total']);

            $this->keranjang = [];
            $this->total = 0;
            $this->metodePembayaran = '';

            DB::commit();

            session()->flash('message', 'Pembayaran berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'Terjadi kesalahaan saat menyimpan transaksi');
        }
    }

    public function render()
    {
        return view('livewire.check-out-page');
    }
}
