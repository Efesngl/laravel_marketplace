<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        "order_id",
        "product_id",
        "status_id",
        "quantity",
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function status():BelongsTo{
        return $this->belongsTo(OrderStatus::class);
    }
}
