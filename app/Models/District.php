<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "city_id"
    ];

    public function city():BelongsTo{
        return $this->belongsTo(City::class);
    }

    public function neighbourhoods():HasMany{
        return $this->hasMany(Neighbourhood::class);
    }
    public function deal():HasMany{
        return $this->hasMany(Deal::class);
    }
}
