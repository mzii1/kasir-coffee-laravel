<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Menu;

class TransaksiPage extends Component
{
    public $menus = [];
    public $keranjang = [];
    public $total = 0;

    public function mount()
    {
        $this->menus = Menu::all();
        $this->keranjang = session('keranjang', []);
        $this->total = session('total', 0);
    }

    public function tambah($id)
    {
        $menu = Menu::findOrFail($id);

        if (!isset($this->keranjang[$id])) {
            $this->keranjang[$id] = [
                'id' => $menu->id,
                'nama' => $menu->nama,
                'harga' => $menu->harga,
                'jumlah' => 0,
                'subtotal' => 0,
            ];
        }

        $this->keranjang[$id]['jumlah'] += 1;
        $this->keranjang[$id]['subtotal'] = $this->keranjang[$id]['jumlah'] * $this->keranjang[$id]['harga'];

        $this->updateSession();
    }

    public function kurang($id)
    {
        if (isset($this->keranjang[$id])) {
            $this->keranjang[$id]['jumlah']--;

            if ($this->keranjang[$id]['jumlah'] <= 0) {
                unset($this->keranjang[$id]);
            } else {
                $this->keranjang[$id]['subtotal'] = $this->keranjang[$id]['jumlah'] * $this->keranjang[$id]['harga'];
            }

            $this->updateSession();
        }
    }

    public function hapusKeranjang()
    {
        $this->keranjang = [];
        $this->total = 0;
        session()->forget(['keranjang', 'total']);
    }

    public function tambahKeranjang(){

    }


    public function updateSession()
    {
        $this->total = array_sum(array_column($this->keranjang, 'subtotal'));
        session(['keranjang' => $this->keranjang, 'total' => $this->total]);
    }

    public function render()
    {
        return view('livewire.transaksi-page');
    }
}
