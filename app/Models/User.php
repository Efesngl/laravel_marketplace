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
        "phone_number",
        "gender",
        "birth_date",
        "iban",
        "sub_merchant_id",
        "tc_no",
        "sub_merchant_address"
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
    public function adresses():HasMany{
        return $this->hasMany(UserAddress::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function chats():BelongsToMany
    {
        return $this->belongsToMany(Chat::class);
    }
    public function favorites():HasMany{
        return $this->hasMany(Favorite::class);
    }
    public function orders():HasMany{
        return $this->hasMany(Order::class);
    }
    public function cart():HasMany{
        return $this->hasMany(ShoppingCart::class);
    }
}
