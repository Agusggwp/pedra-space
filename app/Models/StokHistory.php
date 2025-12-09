<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokHistory extends Model
{
    protected $table = 'stok_histories';

    protected $fillable = [
        'produk_id',
        'tipe',
        'jumlah',
        'keterangan',
        'user_id'
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}