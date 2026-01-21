<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = [
        'nama_pembayaran',
        'is_active',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
