<?php

namespace Database\Seeders;

use App\Models\CustomerOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerOrder::factory()
            ->count(30)
            ->hasDelivery(1)
            ->create()
        ;
    }
}