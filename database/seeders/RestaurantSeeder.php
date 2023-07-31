<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use Faker\Factory as Faker;

class RestaurantSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            Restaurant::create([
                'name' => $faker->company,
                'description' => $faker->paragraph,
                'address' => $faker->address,
                'contact_number' => $faker->phoneNumber,
            ]);
        }
    }
}


