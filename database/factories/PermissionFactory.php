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
        $perms = [];
        # $gender = $this->faker->randomElement((["male", "female"]));
        $status = $this->faker->randomElement((["Revoked"]));

        do {
            $permission = $this->faker->randomElement(([
                "Read Custommers",
                "Edit Custommers",
                "Add Custommers",
                "Read Drivers",
                "Edit Drivers",
                "Add Drivers",
                "Read Deliveries",
                "Edit Deliveries",
                "Add Deliveries",
                "Read Admin",
                "Edit Admin",
                "Add Admin",
                "Read Order",
                "Edit Order",
                "Add Order",
                "Read Payments",
                "Edit Payments",
                "Add Payments"
            ]));

        } while (in_array($permission, $perms));

        $perms[] = $permission;
        return [
            'admin_id' => Admin::factory(),
            'permission' => $permission,
            'status' => $status,
        ];
    }
}