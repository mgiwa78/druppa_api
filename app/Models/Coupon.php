<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'forUser',
        'validFrom',
        'percentageDiscount',
        'reductionAmount',
        'validUntil',
        'maxUses',
        'currentUses',
        'couponType',
    ];


    public function couponRecords()
    {
        return $this->hasMany(CouponRecord::class);
    }
}