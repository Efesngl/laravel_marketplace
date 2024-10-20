<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "title",
        "price",
        "description",
        "user_id",
        "is_active",
        "category_id",
        "banner",
        "stock",
        "quantity_per_user",
    ];
    protected $appends = ["formatted_price"];

    protected function banner(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Storage::url($value),
        );
    }
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => number_format($this->price, 2, ",", "."),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class)->select("id", "specification_id", "product_id", "value_id");
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
    public function cart(): HasMany
    {
        return $this->hasMany(ShoppingCart::class);
    }
    public function orders():HasMany{
        return $this->hasMany(OrderProduct::class);
    }
}
