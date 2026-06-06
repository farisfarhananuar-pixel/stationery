<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    protected $fillable = [
        'user_id', 'shop_name', 'shop_description', 'shop_logo',
        'bank_name', 'bank_account', 'qr_code_image', 'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
