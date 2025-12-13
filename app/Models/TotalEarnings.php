<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalEarnings extends Model
{
    protected $table = 'total_earnings';

    protected $fillable = [
        'user_id',
        'saldo_akhir',
        'keterangan'
    ];

    protected $casts = [
        'saldo_akhir' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
