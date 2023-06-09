<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'amount' => $this->faker->randomFloat(2, 10, 100),
            'paystack_refrence_id' => $this->faker->uuid,
            'currency' => $this->faker->currencyCode(),
            'payment_method' => $this->faker->randomElement(['Credit Card', 'PayPal', 'Bank Transfer']),
            'status' => $this->faker->boolean(80),
        ];
    }
}