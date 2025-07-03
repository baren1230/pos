<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionItem;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_method',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
