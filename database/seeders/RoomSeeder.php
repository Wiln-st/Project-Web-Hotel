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
        $rooms = [

            [
                'room_number' => '1',
                'room_type_id' => 1,
                'status' => 'tersedia'
            ],

            [
                'room_number' => '2',
                'room_type_id' => 1,
                'status' => 'penuh'
            ],

            [
                'room_number' => '3',
                'room_type_id' => 1,
                'status' => 'pemeliharaan'
            ],

            [
                'room_number' => '4',
                'room_type_id' => 1,
                'status' => 'tersedia'
            ],

            [
                'room_number' => '5',
                'room_type_id' => 2,
                'status' => 'dipesan'
            ],

            [
                'room_number' => '6',
                'room_type_id' => 2,
                'status' => 'penuh'
            ],

            [
                'room_number' => '7',
                'room_type_id' => 3,
                'status' => 'tersedia'
            ],

            [
                'room_number' => '8',
                'room_type_id' => 3,
                'status' => 'penuh'
            ],

        ];

        foreach ($rooms as $room) {

            Room::create($room);
        }
    }
}
