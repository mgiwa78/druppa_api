<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class WarehouseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
            Warehouse::create([
                'name' => $faker->company,
                'location' => $faker->address,
                'capacity' => $faker->numberBetween(1000, 5000),
            ]);
        }
    }
}