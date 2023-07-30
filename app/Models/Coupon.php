<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', // 'code' to allow mass assignment for the 'code' attribute
        'discount',
        'valid_from',
        'valid_until',
        'max_uses',
        'current_uses',
        'user_id',
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_coupon')
            ->withTimestamps();
    }
    
}
