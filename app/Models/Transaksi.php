<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'shift_kasir_id',
        'metode_pembayaran',
        'total',
        'bayar',
        'kembalian',
        'status',
        'keterangan_void',
        'void_at',
        'void_by'
    ];

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function voidBy()
    {
        return $this->belongsTo(User::class, 'void_by');
    }

    // 🔥 Relasi ke shift sesi kasir
    public function shiftKasir()
    {
        return $this->belongsTo(ShiftKasir::class, 'shift_kasir_id');
    }
}
