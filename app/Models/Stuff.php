<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stuff extends Model
{
    protected $fillable = [
        'category_id',
        'nama_barang',
        'image',
        'harga_barang',
        'keterangan_barang',
        'stok_barang',
        'exp_barang',
        'status_ketersediaan',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function detailTransactions(): HasMany
    {
        return $this->hasMany(DetailTransaction::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}
