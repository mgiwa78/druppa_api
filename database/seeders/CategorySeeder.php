<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $restaurants = \App\Models\Restaurant::all();

        foreach ($restaurants as $restaurant) {
            for ($i = 0; $i < 3; $i++) {
                $restaurant->categories()->create([
                    'name' => $faker->word,
                ]);
            }
        }
    }
}


