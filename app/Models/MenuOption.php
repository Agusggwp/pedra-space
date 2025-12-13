<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuOption extends Model
{
    protected $table = 'menu_options';
    protected $fillable = [
        'menu_id',
        'tipe',
        'nama_option',
        'nilai'
    ];

    // Relasi ke Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
