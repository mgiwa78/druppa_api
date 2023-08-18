<?php

namespace Database\Seeders;

use App\Models\WalletTransactions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletTransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WalletTransactions::factory()
            ->count(8)
            ->create([
                'customer_id' => 7,
            ]);
    }
}