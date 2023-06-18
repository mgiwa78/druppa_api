<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Delivery;
use App\Models\Customer;
use Faker\Factory as Faker;

class DeliveryRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $customers = Customer::all();

        foreach ($customers as $customer) {
            $deliveryCount = Delivery::where('customer_id', $customer->id)->count();
            $deliveriesNeeded = 5 - $deliveryCount;

            for ($i = 0; $i < $deliveriesNeeded; $i++) {
                Delivery::create([
                    'customer_id' => $customer->id,
                    'item' => $faker->word,
                    'delivery_id' => $faker->uuid,
                    'price' => $faker->randomFloat(2, 10, 1000),
                    'address' => $faker->address,
                    'country' => $faker->country,
                    'state' => $faker->state,
                    'status' => $faker->randomElement(['In Process', 'Delivered']),
                ]);
            }
        }
    }
}
