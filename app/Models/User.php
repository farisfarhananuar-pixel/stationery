<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'address', 'profile_photo', 'is_active'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function sellerProfile() {
        return $this->hasOne(SellerProfile::class);
    }

    public function products() {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function sellerOrders() {
        return $this->hasMany(Order::class, 'seller_id');
    }

    public function cart() {
        return $this->hasMany(Cart::class);
    }

    public function isSeller() { return $this->role === 'seller'; }
    public function isAdmin() { return $this->role === 'admin'; }
    public function isUser() { return $this->role === 'user'; }
}
