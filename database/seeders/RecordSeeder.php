<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Record;
use App\Models\Product;
use Faker\Factory as Faker;

class RecordSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $productIds = \App\Models\Product::pluck('id')->toArray();

        foreach ($productIds as $productId) {
            $quantity = $faker->numberBetween(5, 30);

            Record::create([
                'product_id' => $productId,
                'action' => 'sent_for_warehousing',
                'quantity' => $quantity,
            ]);

            Record::create([
                'product_id' => $productId,
                'action' => 'requested_delivery',
                'quantity' => $quantity - $faker->numberBetween(1, $quantity),
                'address' => $faker->address,
            ]);
        }
    }
}
