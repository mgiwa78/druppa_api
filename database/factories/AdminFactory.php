<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

      
        $emial_verified = $this->faker->randomElement(([true, false]));

        $emial_verified_at = $emial_verified ? $this->faker->dateTimeThisDecade('-1 years') : null;
        $gender = $this->faker->randomElement((["male", "female"]));
        $type = $this->faker->randomElement((["User", "Driver", "Admin"]));


  $emails = [];

        do {
            $email = $this->faker->safeEmail();
        } while (in_array($email, $emails));

        $emails[] = $email;

        return [
            'password' => Hash::make("Password"),
            'type' => 'Admin',
            'gender' => $gender,
            'title' => $this->faker->title($gender),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'firstName' => $this->faker->firstName($gender),
            'lastName' => $this->faker->lastName(),
            'email' => $email,
            'last_login' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
        ];
    }
}