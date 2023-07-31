<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CustomerSeeder::class,
            DriverSeeder::class,
            AdminSeeder::class,
            PaymentSeeder::class,
            DeliverySeeder::class,
            WarehouseSeeder::class,
            CustomerOrderSeeder::class,
            CouponSeeder::class,
            RetainershipCustomersSeeder::class,
            ProductSeeder::class,
            RecordSeeder::class,
            RestaurantSeeder::class,
            CategorySeeder::class,
            CategoryProductSeeder::class,
        ]);
    }
}