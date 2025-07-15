<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['tanggal', 'total', 'metode_pembayaran'];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
