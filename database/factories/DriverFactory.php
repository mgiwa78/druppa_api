<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
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
        return [
            'password' => Hash::make("Password"),

            // Replace 'password' with the desired default password
            'firstName' => $this->faker->firstName($gender),
            'lastName' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'gender' => $gender,
            'title' => $this->faker->title($gender),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->streetAddress(),
            'type' => 'Driver',
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'isActive' => $this->faker->randomElement([false, true]),
            'licenseNumber' => $this->faker->randomNumber(),
            'licenseExpiration' => $this->faker->date(),
            'vehicleMake' => $this->faker->word(),
            'vehicleModel' => $this->faker->word(),
            'licensePlate' => $this->faker->word(),
            'insurance' => $this->faker->word(),
        ];
    }
}