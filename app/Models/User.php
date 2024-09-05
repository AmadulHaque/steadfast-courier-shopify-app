<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Order;
use Laravel\Sanctum\HasApiTokens;
use Osiset\ShopifyApp\Traits\ShopModel;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Osiset\ShopifyApp\Contracts\ShopModel as IShopModel;

class User extends Authenticatable implements IShopModel
{
    use HasApiTokens, HasFactory, Notifiable, ShopModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'appStatus',
        'apiKey',
        'secretKey',
        'businessName',
        'businessAddress',
        'businessEmail',
        'businessNumber',
        'businessLogo',
        'businessTerms',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];


    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
