<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            CustomerActivity::create([
                'customer_id' => $customer->id,
                'activity' => 'Logged in',
            ]);

            CustomerActivity::create([
                'customer_id' => $customer->id,
                'activity' => 'Viewed profile',
            ]);
        }
    }
}
