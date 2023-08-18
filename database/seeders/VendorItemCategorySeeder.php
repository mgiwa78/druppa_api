<?php

namespace Database\Seeders;

use App\Models\VendorItem;
use App\Models\VendorItemCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                VendorItemCategory::factory()
            ->count(1)
            ->create([
                'name' => "desert",
            ]);

                VendorItemCategory::factory()
            ->count(1)
            ->create([
                'name' => "meal",
            ]);
                VendorItemCategory::factory()
            ->count(1)
            ->create([
                'name' => "hausa delicacy",
            ]);
                VendorItemCategory::factory()
            ->count(1)
            ->create([
                'name' => "yoruba delicacy",
            ]);
    }
}
