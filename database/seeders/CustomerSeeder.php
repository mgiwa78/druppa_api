<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()
            ->count(5)
            ->hasDelivery(5)
            ->hasInventries(10)
            ->hasOrders(9)
            ->hasPayment(1)
            ->hasInvoice(12)
            ->create()
        ;
    }
}