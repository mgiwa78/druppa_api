<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerOrder;
use App\Models\Delivery;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
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
            'tracking_number' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(['Pending Pickup', 'In Transit', 'Delivered']),
            'time_taken' => $this->faker->randomFloat(2, 10, 500),

            'pickup_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),

            'delivery_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'driver_id' => Driver::factory(),
            'customer_order_id' => CustomerOrder::factory(),
        ];
    }
}