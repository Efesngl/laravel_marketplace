<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSpecification extends Pivot
{
    //
    protected $fillable = [
        "specification_id",
        "product_id",
        "value_id"
    ];

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function specification(): BelongsTo{
        return $this->belongsTo(Specification::class);
    }
    public function value():BelongsTo{
        return $this->belongsTo(SpecificationValue::class);
    }
}
