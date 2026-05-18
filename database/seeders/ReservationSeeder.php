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
                'rooms' => [$rooms[0]->id],
                'customer_name' => 'Ahmad Fauzi',
                'phone' => '081234567890',
                'check_in' => Carbon::now()->subDays(2),
                'check_out' => Carbon::now()->addDays(2),
                'total_price' => 1050000,
                'facilities' => ['makan', 'wifi'],
            ],

            [
                'rooms' => [$rooms[1]->id],
                'customer_name' => 'Budi Santoso',
                'phone' => '082345678901',
                'check_in' => Carbon::now(),
                'check_out' => Carbon::now()->addDays(3),
                'total_price' => 2250000,
                'facilities' => ['parkir'],
            ],

            [
                'rooms' => [$rooms[2]->id],
                'customer_name' => 'Citra Lestari',
                'phone' => '083456789012',
                'check_in' => Carbon::now()->subDays(5),
                'check_out' => Carbon::now()->subDays(1),
                'total_price' => 3150000,
                'facilities' => ['makan', 'parkir', 'wifi'],
            ],

            [
                'rooms' => [$rooms[3]->id],
                'customer_name' => 'Dewi Anggraini',
                'phone' => '084567890123',
                'check_in' => Carbon::now()->addDay(),
                'check_out' => Carbon::now()->addDays(4),
                'total_price' => 1800000,
                'facilities' => ['wifi'],
            ],

            [
                'rooms' => [$rooms[4]->id],
                'customer_name' => 'Eko Prasetyo',
                'phone' => '085678901234',
                'check_in' => Carbon::now(),
                'check_out' => Carbon::now()->addDays(1),
                'total_price' => 750000,
                'facilities' => ['parkir'],
            ],

            [
                'rooms' => [$rooms[5]->id],
                'customer_name' => 'Fitri Amelia',
                'phone' => '086789012345',
                'check_in' => Carbon::now()->subDays(1),
                'check_out' => Carbon::now()->addDays(2),
                'total_price' => 2400000,
                'facilities' => ['makan'],
            ],

            [
                'rooms' => [$rooms[6]->id],
                'customer_name' => 'Galang Saputra',
                'phone' => '087890123456',
                'check_in' => Carbon::now()->subDays(3),
                'check_out' => Carbon::now()->subDays(1),
                'total_price' => 1500000,
                'facilities' => ['wifi'],
            ],

            [
                'rooms' => [$rooms[7]->id],
                'customer_name' => 'Hana Putri',
                'phone' => '088901234567',
                'check_in' => Carbon::now()->addDays(2),
                'check_out' => Carbon::now()->addDays(5),
                'total_price' => 3300000,
                'facilities' => ['makan', 'parkir'],
            ],

            // Contoh multi room booking
            [
                'rooms' => [$rooms[0]->id, $rooms[1]->id],
                'customer_name' => 'PT Global Meeting',
                'phone' => '089912345678',
                'check_in' => Carbon::now()->addDays(1),
                'check_out' => Carbon::now()->addDays(3),
                'total_price' => 4500000,
                'facilities' => ['wifi', 'makan', 'parkir'],
            ],

        ];

        foreach ($reservations as $data) {

            // Simpan reservation
            $reservation = Reservation::create([
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'total_price' => $data['total_price'],
                'facilities' => $data['facilities'],
                'status' => 'booking',
            ]);

            // Simpan relasi ke pivot table
            $reservation->rooms()->attach($data['rooms']);

            // Update status room
            Room::whereIn('id', $data['rooms'])->update([
                'status' => 'penuh'
            ]);
        }
    }
}