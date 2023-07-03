<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_order_id' => CustomerOrder::factory(),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}