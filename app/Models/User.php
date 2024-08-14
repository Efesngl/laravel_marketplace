<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "id",
        'name',
        'email',
        'password',
        "phone_number",
        "gender",
        "birth_date",
        "iban",
        "sub_merchant_key",
        "tc_no"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            "birth_date"=>"date:Y-m-d"
        ];
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function chats():BelongsToMany
    {
        return $this->belongsToMany(Chat::class);
    }
    public function favorites():HasMany{
        return $this->hasMany(Favorite::class);
    }
}
