<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = [
        "specification"
    ];

    public function values(): HasMany
    {
        return $this->hasMany(SpecificationValue::class);
    }
    public function specifications(): HasMany
    {
        return $this->hasMany(DealSpecification::class);
    }

    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class);
    }
}
