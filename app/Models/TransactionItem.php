<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use App\Models\Produk;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'produk_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
