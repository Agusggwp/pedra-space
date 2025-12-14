<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['kode','nama','category_id','harga_beli','harga_jual','stok','foto'];

    public function category() { return $this->belongsTo(Category::class); }
    public function transaksiDetails() { return $this->hasMany(TransaksiDetail::class); }
}