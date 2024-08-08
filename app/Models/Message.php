<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        "message",
        "user_id",
        "chat_id"
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => date_format(date_create($value), "d.m.Y H:i:s"),
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
