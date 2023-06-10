<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permissions>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        # $gender = $this->faker->randomElement((["male", "female"]));
        $permission = $this->faker->randomElement((["Read Custommers", "Edit Custommers", "Add Custommers"]));
        $status = $this->faker->randomElement((["Revoked"]));

        return [
            'admin_id' => Admin::factory(),
            'permission' => $permission,
            'status' => $status,
        ];
    }
}