<?php

namespace Database\Factories;

use App\Models\Customer;
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
            'customer_id' => Customer::factory(),
            'service_rendered' => $this->faker->word,
            'delivery_address' => $this->faker->address,
            'pickup_address' => $this->faker->address,
            'payment_method' => $this->faker->randomElement(['Paystack', 'Cash']),
            'currency' => $this->faker->currencyCode,
            'expected_delivery_date' => $this->faker->date,
            'expected_delivery_time' => $this->faker->time,
            'payment_id' => $this->faker->uuid,
            'paystack_refrence_id' => $this->faker->uuid,
            'total_payment' => $this->faker->randomFloat(2, 10, 500),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}