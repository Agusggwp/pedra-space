<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = ['kode','nama','category_id','harga_beli','harga_jual','stok','foto'];

    public function category() { return $this->belongsTo(Category::class); }
}