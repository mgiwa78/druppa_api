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
            ->count(1)
            ->hasDeliveries(1)
            ->hasInventries(1)
            ->hasOrders(1)
            ->hasPayment(1)
            ->hasInvoice(1)
            ->create()
        ;

        Customer::factory()
            ->hasInventries(5)
            ->hasOrders(5)
            ->hasPayment(5)
            ->hasInvoice(5)
            ->create([
                'email' => 'customer@mail.com',
                'type' => 'Customer',
                'firstName' => 'Muhammad',
                'lastName' => 'Giwa',
                'title' => 'Mr',
                'password' => bcrypt('Password'),
            ]);
    }
}