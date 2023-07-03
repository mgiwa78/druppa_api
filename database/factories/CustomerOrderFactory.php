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

            'service_rendered' => $this->faker->randomElement(['Fragile Shipments', 'Dropship Shipments', 'Oversized Shipments', 'Perishable Shipments', 'Express Shipments']),
            'payment_method' => $this->faker->randomElement(['Paystack', 'Cash']),
            'expected_delivery_date' => $this->faker->dateTime(),


            'total_payment' => $this->faker->randomFloat(2, 10, 500),
            'shipment_weight' => $this->faker->randomFloat(2, 3, 40),

            'dropOff_address' => $this->faker->address,
            'dropOff_state' => $this->faker->state(),
            'dropOff_city' => $this->faker->city(),
            'dropOff_LGA' => $this->faker->cityPrefix(),
            'pickup_address' => $this->faker->address,
            'pickup_state' => $this->faker->state(),
            'pickup_city' => $this->faker->city(),
            'pickup_lga' => $this->faker->cityPrefix(),



            'status' => $this->faker->randomElement(['Pending', 'In Transit', 'Pending Pickup', 'Delivered']),

        ];
    }
}