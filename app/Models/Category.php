<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['nama'];
    public function produks() { return $this->hasMany(Produk::class); }

    // Relasi ke Menu
    public function menus() {
        return $this->hasMany(\App\Models\Menu::class, 'category_id');
    }
}
