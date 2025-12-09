<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id', 'metode_pembayaran', 'total', 'bayar', 'kembalian',
        'status', 'keterangan_void', 'void_at', 'void_by'
    ];

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voidBy()
    {
        return $this->belongsTo(User::class, 'void_by');
    }
}