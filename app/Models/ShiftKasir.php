<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;  // INI YANG WAJIB DITAMBAHKAN!
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShiftKasir extends Model
{
    protected $fillable = [
        'user_id',
        'saldo_awal',
        'saldo_akhir',
        'selisih',
        'ditutup_pada',
        'status'
    ];

    protected $casts = [
        'dibuka_pada' => 'datetime',
        'ditutup_pada' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeBuka($query)
    {
        return $query->where('status', 'buka');
    }
}