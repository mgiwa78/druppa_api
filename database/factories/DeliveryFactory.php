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
            'status' => $this->faker->randomElement(['Pending', 'In Transit', 'Delivered']),
            'origin' => $this->faker->address(),
            'destination' => $this->faker->address(),
            'time_taken' => $this->faker->time(),
            'pickup_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'state' => $this->faker->state(),
            'distance' => $this->faker->randomFloat(2, 0, 100),
            'city' => $this->faker->city(),
            'delivery_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'driver_id' => Driver::factory(),
            'customer_order_id' => CustomerOrder::factory(),
        ];
    }
}