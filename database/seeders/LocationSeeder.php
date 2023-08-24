<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::factory()
            ->create([
                'name' => 'Abuja',
                'address' => 'Customer',
            ]);

        Location::factory()
            ->create([
                'name' => 'Yola',
                'address' => 'Customer',
            ]);

        Location::factory()
            ->create([
                'name' => 'Bauchi',
                'address' => 'Customer',
            ]);


    }
}