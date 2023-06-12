<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $emails = [];
        $emial_verified = $this->faker->randomElement(([true, false]));

        $emial_verified_at = $emial_verified ? $this->faker->dateTimeThisDecade('-1 years') : null;
        $gender = $this->faker->randomElement((["male", "female"]));




        do {
            $email = $this->faker->email();
        } while (in_array($email, $emails));

        $emails[] = $email;

        // Output the unique email
        return [
            'firstName' => $this->faker->firstName($gender),
            'lastName' => $this->faker->lastName(),
            'gender' => $gender,
            'type' => "Customer",
            'title' => $this->faker->title($gender),
            'email' => $email,
            'phone_number' => $this->faker->phoneNumber(),
            'email_verified_at' => $emial_verified_at,
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'password' => Hash::make("Password")
        ];
    }
}