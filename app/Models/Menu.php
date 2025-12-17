<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga_base',
        'harga_beli',
        'category_id',
        'foto',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'harga_base' => 'float'
    ];

    // Relasi ke category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke menu options (customization)
    public function options()
    {
        return $this->hasMany(MenuOption::class);
    }

    // Relasi ke diskon
    public function diskon()
    {
        return $this->hasMany(Diskon::class, 'menu_id')->aktif();
    }
}
