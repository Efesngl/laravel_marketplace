<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DealSpecification extends Pivot
{
    //
    protected $table = "deal_specification_pivot";
    protected $fillable = [
        "specification_id",
        "deal_id",
        "value_id"
    ];

    public function deal():BelongsTo{
        return $this->belongsTo(Deal::class);
    }

    public function specification(): BelongsTo{
        return $this->belongsTo(Specification::class);
    }
    public function value():BelongsTo{
        return $this->belongsTo(SpecificationValue::class);
    }
}
