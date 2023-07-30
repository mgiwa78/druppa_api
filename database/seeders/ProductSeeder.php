<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $warehouseIds = \App\Models\Warehouse::pluck('id')->toArray();

        for ($i = 1; $i <= 20; $i++) {
            Product::create([
                'name' => $faker->sentence(),
                'warehouse_id' => $faker->randomElement($warehouseIds),
                'quantity' => $faker->numberBetween(50, 200),
            ]);
        }
    }
}
