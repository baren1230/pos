<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PembelianItem;
use App\Models\Supplier;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelians';

    protected $fillable = [
        'supplier_id',
        'tanggal',
        'total_amount',
    ];

    public function items()
    {
        return $this->hasMany(PembelianItem::class, 'pembelian_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
