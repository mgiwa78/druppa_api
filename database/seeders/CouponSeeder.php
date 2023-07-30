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
            'discount' => 10.00,
            'valid_from' => now(),
            'valid_until' => now()->addMonth(),
            'max_uses' => 100,
            'current_uses' => 0,
            'user_id' => 1, // Assuming the admin user has ID 1
        ]);

        Coupon::create([
            'code' => 'SALE50',
            'discount' => 50.00,
            'valid_from' => now(),
            'valid_until' => now()->addMonth(),
            'max_uses' => 50,
            'current_uses' => 0,
            'user_id' => 1, // Assuming the admin user has ID 1
        ]);
    }
}
