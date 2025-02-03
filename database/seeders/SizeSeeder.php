<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Size::create([
            'name' =>'200 ml',
            'unit' =>'ml',
        ]);
        Size::create([
            'name' =>'450 ml',
            'unit' =>'ml',
        ]);
        Size::create([
            'name' =>'1L',
            'unit' =>'litre',
        ]);
        Size::create([
            'name' =>'1.5L',
            'unit' =>'litre',
        ]);
        Size::create([
            'name' =>'2L',
            'unit' =>'litre',
        ]);
    }
}
