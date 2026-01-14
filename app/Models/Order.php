<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'total_amount',
        'status',
        'user_id',
        'amount',
        'method',
        'response',
        'transaction_reference',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
