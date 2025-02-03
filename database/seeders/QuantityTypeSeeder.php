<?php

namespace Database\Seeders;

use App\Models\QuantityType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuantityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QuantityType::create([
            'name' => 'حبة',
        ]);
        QuantityType::create([
            'name' => 'باكيت',
        ]);
        QuantityType::create([
            'name' => 'كرتونة',
        ]);
    }
}
