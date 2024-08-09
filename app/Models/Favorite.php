<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable=[
        "deal_id",
        "user_id"
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function deal():BelongsTo{
        return $this->belongsTo(Deal::class);
    }
}
