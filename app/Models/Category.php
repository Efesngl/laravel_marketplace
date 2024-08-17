<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "category",
        "parent_id",
        "can_have_children"
    ];
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, "parent_id", "id")->with("children:category,parent_id,id,can_have_children");
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, "parent_id", "id")->with("parent");
    }

    public function specifications(): BelongsToMany{
        return $this->belongsToMany(Specification::class);
    }
}
