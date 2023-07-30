<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RetainershipCustomer;

class RetainershipCustomersSeeder extends Seeder
{
    public function run()
    {
        // Sample Retainership customer data
        $retainershipCustomers = [
            [
                'customer_name' => 'Customer A',
                'contract_start_date' => '2023-01-01',
                'contract_end_date' => '2023-12-31',
                'discount_percentage' => 10.00,
            ],
            [
                'customer_name' => 'Customer B',
                'contract_start_date' => '2023-02-15',
                'contract_end_date' => '2023-11-30',
                'discount_percentage' => 15.50,
            ],
            // Add more sample data as needed
        ];

        // Insert the data into the database
        foreach ($retainershipCustomers as $customerData) {
            RetainershipCustomer::create($customerData);
        }
    }
}