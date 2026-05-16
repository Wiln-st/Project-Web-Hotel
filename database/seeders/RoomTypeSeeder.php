<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\RoomType::create([
            'name' => 'Superior',
            'price' => 450000,
        ]);

        \App\Models\RoomType::create([
            'name' => 'Deluxe',
            'price' => 750000,
        ]);

        \App\Models\RoomType::create([
            'name' => 'Suite',
            'price' => 1100000,
        ]);
    }
}
