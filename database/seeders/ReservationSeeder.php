<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();

        if ($rooms->count() < 8) {
            return;
        }

        $reservations = [

            [
                'room_id' => $rooms[0]->id,
                'customer_name' => 'Ahmad Fauzi',
                'phone' => '081234567890',
                'check_in' => Carbon::now()->subDays(2),
                'check_out' => Carbon::now()->addDays(2),
                'total_price' => 1050000,
                'facilities' => ['makan', 'wifi'],
            ],

            [
                'room_id' => $rooms[1]->id,
                'customer_name' => 'Budi Santoso',
                'phone' => '082345678901',
                'check_in' => Carbon::now(),
                'check_out' => Carbon::now()->addDays(3),
                'total_price' => 2250000,
                'facilities' => ['parkir'],
            ],

            [
                'room_id' => $rooms[2]->id,
                'customer_name' => 'Citra Lestari',
                'phone' => '083456789012',
                'check_in' => Carbon::now()->subDays(5),
                'check_out' => Carbon::now()->subDays(1),
                'total_price' => 3150000,
                'facilities' => ['makan', 'parkir', 'wifi'],
            ],

            [
                'room_id' => $rooms[3]->id,
                'customer_name' => 'Dewi Anggraini',
                'phone' => '084567890123',
                'check_in' => Carbon::now()->addDay(),
                'check_out' => Carbon::now()->addDays(4),
                'total_price' => 1800000,
                'facilities' => ['wifi'],
            ],

            [
                'room_id' => $rooms[4]->id,
                'customer_name' => 'Eko Prasetyo',
                'phone' => '085678901234',
                'check_in' => Carbon::now(),
                'check_out' => Carbon::now()->addDays(1),
                'total_price' => 750000,
                'facilities' => ['parkir'],
            ],

            [
                'room_id' => $rooms[5]->id,
                'customer_name' => 'Fitri Amelia',
                'phone' => '086789012345',
                'check_in' => Carbon::now()->subDays(1),
                'check_out' => Carbon::now()->addDays(2),
                'total_price' => 2400000,
                'facilities' => ['makan'],
            ],

            [
                'room_id' => $rooms[6]->id,
                'customer_name' => 'Galang Saputra',
                'phone' => '087890123456',
                'check_in' => Carbon::now()->subDays(3),
                'check_out' => Carbon::now()->subDays(1),
                'total_price' => 1500000,
                'facilities' => ['wifi'],
            ],

            [
                'room_id' => $rooms[7]->id,
                'customer_name' => 'Hana Putri',
                'phone' => '088901234567',
                'check_in' => Carbon::now()->addDays(2),
                'check_out' => Carbon::now()->addDays(5),
                'total_price' => 3300000,
                'facilities' => ['makan', 'parkir'],
            ],

        ];

        foreach ($reservations as $reservation) {

            Reservation::create($reservation);

            Room::find($reservation['room_id'])->update([
                'status' => 'penuh'
            ]);
        }
    }
}