<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 1; $i <= 25; $i++) {

            Room::create([
                'room_number' => (int) $i,
                'room_type_id' => rand(1, 3),
                'status' => 'tersedia',
            ]);
        }
    }
}
