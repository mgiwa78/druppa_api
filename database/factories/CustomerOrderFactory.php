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
            'shipment_description' => $this->faker->paragraph(),
            'delivery_instructions' => $this->faker->paragraph(),

            'package_type' => $this->faker->randomElement(['Fragile Shipments', 'Dropship Shipments', 'Oversized Shipments', 'Perishable Shipments', 'Express Shipments']),
            'payment_type' => $this->faker->randomElement(['Paystack', 'Cash']),
            'location_type' => $this->faker->randomElement(["Inter-State", "Within-State"]),


            'total_payment' => $this->faker->randomFloat(2, 10, 500),
            'origin' => $this->faker->state(),
            'dropoff_address' => $this->faker->address(),
            'dropoff_state' => $this->faker->state(),
            'pickup_address' => $this->faker->address(),
            'pickup_state' => $this->faker->state(),
            'status' => "Pending",

        ];
    }
}