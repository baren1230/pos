<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianItem extends Model
{
    use HasFactory;

    protected $table = 'pembelian_items';

    protected $fillable = [
        'pembelian_id',
        'produk_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
