<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Driver::factory()
            ->create([
                'email' => 'driver@mail.com',
                'type' => 'Driver',
                'firstName' => 'Muhammad',
                'lastName' => 'Giwa',
                'title' => 'Mr',
                'password' => bcrypt('Password'),
            ]);
    }
}