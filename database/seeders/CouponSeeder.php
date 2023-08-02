<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create sample coupons
        Coupon::create([
            'code' => 'SUMMER2023',
            'percentageDiscount' => 10.00,
            'validFrom' => now(),
            'validUntil' => now()->addMonth(),
            'maxUses' => 100,
            'status' => true,
            'couponType' => "percentageDiscount",
            'currentUses' => 0,
        ]);

        Coupon::create([
            'code' => 'EID2023',
            'reductionAmount' => 500,
            'validFrom' => now(),
            'validUntil' => now()->addMonth(),
            'maxUses' => 100,
            'status' => true,
            'couponType' => "reductionDiscount",
            'currentUses' => 0,
        ]);
    }
}