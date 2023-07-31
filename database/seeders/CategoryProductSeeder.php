<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryProduct;
use Faker\Factory as Faker;

class CategoryProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $categories = \App\Models\Category::all();

        foreach ($categories as $category) {
            for ($i = 0; $i < 5; $i++) {
                $category->categoryProducts()->create([
                    'name' => $faker->word,
                    'description' => $faker->sentence,
                    'price' => $faker->randomFloat(2, 5, 50),
                ]);
            }
        }
    }
}

