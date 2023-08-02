<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryRequest;
use App\Models\Customer;
use App\Models\Inventory;
use Faker\Factory as Faker;

class DeliveryRequestSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $customers = Customer::all();
        foreach ($customers as $customer) {
            $inventory = Inventory::where('customer_id', $customer->id)->inRandomOrder()->first();

            if ($inventory) {
                DeliveryRequest::create([
                    'inventory_id' => $inventory->id,
                    'customer_id' => $customer->id,
                    'address' => $faker->address,
                    'quantity_requested' => $faker->numberBetween(1, $inventory->quantity),
                ]);
            }
        }
    }
}
