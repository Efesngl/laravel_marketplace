<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        "image",
        "product_id"
    ];

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Storage::url($value),
        );
    }
}
