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
        // Ambil semua kamar
        $rooms = Room::all();

        // Minimal 8 kamar
        if ($rooms->count() < 8) {
            return;
        }

        // Reset status semua kamar dulu
        Room::query()->update([
            'status' => 'tersedia'
        ]);

        // Hapus reservation lama biar tidak bentrok
        Reservation::query()->delete();

        $reservations = [

            // ROOM 1
            [
                'rooms' => [$rooms[0]->id],
                'customer_name' => 'Ahmad Fauzi',
                'phone' => '081234567890',
                'check_in' => Carbon::now()->addDays(1),
                'check_out' => Carbon::now()->addDays(3),
                'total_price' => 1050000,
                'facilities' => ['makan', 'wifi'],
            ],

            // ROOM 2
            [
                'rooms' => [$rooms[1]->id],
                'customer_name' => 'Budi Santoso',
                'phone' => '082345678901',
                'check_in' => Carbon::now()->addDays(4),
                'check_out' => Carbon::now()->addDays(6),
                'total_price' => 2250000,
                'facilities' => ['parkir'],
            ],

            // ROOM 3
            [
                'rooms' => [$rooms[2]->id],
                'customer_name' => 'Citra Lestari',
                'phone' => '083456789012',
                'check_in' => Carbon::now()->addDays(7),
                'check_out' => Carbon::now()->addDays(9),
                'total_price' => 3150000,
                'facilities' => ['makan', 'parkir', 'wifi'],
            ],

            // ROOM 4
            [
                'rooms' => [$rooms[3]->id],
                'customer_name' => 'Dewi Anggraini',
                'phone' => '084567890123',
                'check_in' => Carbon::now()->addDays(10),
                'check_out' => Carbon::now()->addDays(12),
                'total_price' => 1800000,
                'facilities' => ['wifi'],
            ],

            // ROOM 5
            [
                'rooms' => [$rooms[4]->id],
                'customer_name' => 'Eko Prasetyo',
                'phone' => '085678901234',
                'check_in' => Carbon::now()->addDays(13),
                'check_out' => Carbon::now()->addDays(14),
                'total_price' => 750000,
                'facilities' => ['parkir'],
            ],

        ];

        foreach ($reservations as $data) {

            // Buat reservasi
            $reservation = Reservation::create([
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'total_price' => $data['total_price'],
                'facilities' => $data['facilities'],
                'status' => 'dipesan'
            ]);

            // Simpan pivot
            $reservation->rooms()->attach($data['rooms']);

            // Update status kamar
            Room::whereIn('id', $data['rooms'])->update([
                'status' => 'dipesan'
            ]);
        }
    }
}