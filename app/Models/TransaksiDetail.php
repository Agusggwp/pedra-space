<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $fillable = ['transaksi_id', 'produk_id', 'menu_id', 'jumlah', 'harga_satuan', 'subtotal', 'options'];

    protected $casts = [
        'options' => 'array'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class)->withDefault();
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}