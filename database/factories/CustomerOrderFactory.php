<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerOrder>
 */
class CustomerOrderFactory extends Factory
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
            'payment_id' => Payment::factory(),
            'request_title' => $this->faker->sentence(),
            'request_description' => $this->faker->paragraph(),
            'total_amount' => $this->faker->randomFloat(2, 100, 1000),
            'drop_off' => $this->faker->address(),
            'pick_up' => $this->faker->address(),
            'payment_method' => $this->faker->randomElement(['Credit Card', 'PayPal', 'Bank Transfer']),
            'payment_status' => $this->faker->boolean(70),
            'shipment_type' => $this->faker->randomElement(['Standard', 'Express']),
            'shipment_details' => $this->faker->paragraph(),

        ];
    }
}