<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Suplayer;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'kategori_id',
        'supplier_id',
        'deskripsi',
        'harga_beli',
        'harga',
        'variasi',
        'ukuran',
        'warna',
        'stok',
        'tanggal_masuk',
        'gambar',
    ];

    public function getStokAwalAttribute()
    {
        return 0;
    }

    public function getMasukAttribute()
    {
        return 0;
    }

    public function getKeluarAttribute()
    {
        return 0;
    }

    public function getStokAkhirAttribute()
    {
        // Calculate stock as sum of stock in minus stock out
        $stockIn = \App\Models\StockMovement::where('produk_id', $this->id)
            ->where('type', 'in')
            ->sum('quantity');

        $stockOut = \App\Models\StockMovement::where('produk_id', $this->id)
            ->where('type', 'out')
            ->sum('quantity');

        return $stockIn - $stockOut;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}