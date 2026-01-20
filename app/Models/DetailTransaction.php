<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaction extends Model
{
    protected $fillable = [
        'stuff_id',
        'sale_id',
        'jumlah',
        'harga_satuan',
        'sub_total',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function stuff(): BelongsTo
    {
        return $this->belongsTo(Stuff::class);
    }
}
