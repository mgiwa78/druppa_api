<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        $emails = [];

        do {
            $email = $this->faker->safeEmail();
        } while (in_array($email, $emails));

        $emails[] = $email;

        $cuisineTypes = [
            'Jollof Rice',
            'Fried Rice',
            'Coconut Rice',
        ];

        return [
            'password' => Hash::make("Password"),
            'email' => $email,
            'vendorName' => $this->faker->company,
            'contactInformation' => $this->faker->address,
            'address' => $this->faker->address(),
        ];
    }
}