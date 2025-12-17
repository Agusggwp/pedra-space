<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diskon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tipe',
        'produk_id',
        'menu_id',
        'category_id',
        'persentase',
        'nominal',
        'nama',
        'deskripsi',
        'aktif',
        'berlaku_dari',
        'berlaku_sampai',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'berlaku_dari' => 'datetime',
        'berlaku_sampai' => 'datetime',
        'persentase' => 'decimal:2',
    ];

    /**
     * Relasi ke Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    /**
     * Relasi ke Menu
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Relasi ke Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope untuk diskon aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope untuk diskon produk
     */
    public function scopeProduk($query)
    {
        return $query->where('tipe', 'produk');
    }

    /**
     * Scope untuk diskon menu
     */
    public function scopeMenu($query)
    {
        return $query->where('tipe', 'menu');
    }

    /**
     * Scope untuk diskon kategori
     */
    public function scopeKategori($query)
    {
        return $query->where('tipe', 'kategori');
    }

    /**
     * Scope untuk diskon umum
     */
    public function scopeUmum($query)
    {
        return $query->where('tipe', 'umum');
    }

    /**
     * Hitung besaran diskon berdasarkan harga
     */
    public function hitungDiskon($harga)
    {
        if ($this->persentase) {
            return round(($harga * $this->persentase) / 100);
        }
        return $this->nominal ?? 0;
    }

    /**
     * Hitung harga setelah diskon
     */
    public function hargaSetelahDiskon($harga)
    {
        return $harga - $this->hitungDiskon($harga);
    }
}
