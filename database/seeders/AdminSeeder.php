<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()
            ->count(30)
            ->create();

        Admin::factory()
            ->create([
                'email' => 'admin@mail.com',
                'type' => 'Admin',
                'location_id' => 1,
                'firstName' => 'Muhammad',
                'lastName' => 'Giwa',
                'title' => 'Mr',
                'password' => bcrypt('Password'),
            ]);
    }
}