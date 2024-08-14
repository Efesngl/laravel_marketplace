<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Deal extends Model
{
    use HasFactory;
    protected $fillable = ["title", "price", "description", "user_id", "is_active", "category_id", "banner"];

    protected function banner(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Storage::url($value),
        );
    }
        protected function price(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => number_format($value,2,",","."),
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
        return $this->hasMany(DealSpecification::class)->select("id", "specification_id", "deal_id", "value_id");
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
    public function neighbourhood(): BelongsTo
    {
        return $this->belongsTo(Neighbourhood::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(DealImage::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }
    public function favorites():HasMany{
        return $this->hasMany(Favorite::class);
    }
}
