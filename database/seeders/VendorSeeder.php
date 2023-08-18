<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::factory()
            ->count(10)
            ->create();

        Vendor::factory()
            ->count(1)
            ->create([
                'email' => "vendor@mail.com",
                'password' => bcrypt("Password"),
                'vendorName' => "Abuja Central Food Stop",
                'contactInformation' => "acfs@mail.com",
                'address' => "house 12, plot 3, maitama",
            ]);
    }
}