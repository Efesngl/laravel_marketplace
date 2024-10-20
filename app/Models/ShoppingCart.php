<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCart extends Model
{
    use HasFactory;
    protected $fillable=[
        "user_id",
        "product_id",
        "quantity",
        "selected"
    ];
    protected function casts():array{
        return [
            "selected"=>"boolean"
        ];
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
