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
            'status' => 'available'
        ]);

        // Hapus reservation lama biar tidak bentrok
        Reservation::query()->delete();

        $reservations = [

            [
                'rooms' => [$rooms[0]->id],
                'customer_name' => 'Ahmad Fauzi',
                'phone' => '081234567890',
                'check_in' => Carbon::now()->addDays(1),
                'check_out' => Carbon::now()->addDays(3),
                'total_price' => 1050000,
                'facilities' => ['makan', 'wifi'],
            ],

            [
                'rooms' => [$rooms[1]->id],
                'customer_name' => 'Budi Santoso',
                'phone' => '082345678901',
                'check_in' => Carbon::now()->addDays(2),
                'check_out' => Carbon::now()->addDays(5),
                'total_price' => 2250000,
                'facilities' => ['parkir'],
            ],

            [
                'rooms' => [$rooms[2]->id],
                'customer_name' => 'Citra Lestari',
                'phone' => '083456789012',
                'check_in' => Carbon::now()->addDays(3),
                'check_out' => Carbon::now()->addDays(6),
                'total_price' => 3150000,
                'facilities' => ['makan', 'wifi', 'parkir'],
            ],

            [
                'rooms' => [$rooms[3]->id],
                'customer_name' => 'Dewi Anggraini',
                'phone' => '084567890123',
                'check_in' => Carbon::now()->addDays(4),
                'check_out' => Carbon::now()->addDays(7),
                'total_price' => 1800000,
                'facilities' => ['wifi'],
            ],

            [
                'rooms' => [$rooms[4]->id],
                'customer_name' => 'Eko Prasetyo',
                'phone' => '085678901234',
                'check_in' => Carbon::now()->addDays(5),
                'check_out' => Carbon::now()->addDays(8),
                'total_price' => 750000,
                'facilities' => ['parkir'],
            ],

            [
                'rooms' => [$rooms[5]->id],
                'customer_name' => 'Fitri Amelia',
                'phone' => '086789012345',
                'check_in' => Carbon::now()->addDays(6),
                'check_out' => Carbon::now()->addDays(9),
                'total_price' => 1250000,
                'facilities' => ['wifi'],
            ],

            [
                'rooms' => [$rooms[6]->id],
                'customer_name' => 'Galih Saputra',
                'phone' => '087890123456',
                'check_in' => Carbon::now()->addDays(7),
                'check_out' => Carbon::now()->addDays(10),
                'total_price' => 2100000,
                'facilities' => ['makan'],
            ],

            [
                'rooms' => [$rooms[7]->id],
                'customer_name' => 'Hana Putri',
                'phone' => '088901234567',
                'check_in' => Carbon::now()->addDays(8),
                'check_out' => Carbon::now()->addDays(11),
                'total_price' => 1600000,
                'facilities' => ['wifi', 'parkir'],
            ],

            [
                'rooms' => [$rooms[0]->id],
                'customer_name' => 'Indra Wijaya',
                'phone' => '089012345678',
                'check_in' => Carbon::now()->addDays(12),
                'check_out' => Carbon::now()->addDays(14),
                'total_price' => 1400000,
                'facilities' => ['makan'],
            ],

            [
                'rooms' => [$rooms[1]->id],
                'customer_name' => 'Joko Susilo',
                'phone' => '081122334455',
                'check_in' => Carbon::now()->addDays(13),
                'check_out' => Carbon::now()->addDays(15),
                'total_price' => 1950000,
                'facilities' => ['wifi'],
            ],

            [
                'rooms' => [$rooms[2]->id],
                'customer_name' => 'Kartika Sari',
                'phone' => '082233445566',
                'check_in' => Carbon::now()->addDays(14),
                'check_out' => Carbon::now()->addDays(17),
                'total_price' => 3200000,
                'facilities' => ['makan', 'parkir'],
            ],

            [
                'rooms' => [$rooms[3]->id],
                'customer_name' => 'Lukman Hakim',
                'phone' => '083344556677',
                'check_in' => Carbon::now()->addDays(15),
                'check_out' => Carbon::now()->addDays(18),
                'total_price' => 1750000,
                'facilities' => ['wifi'],
            ],

            [
                'rooms' => [$rooms[4]->id],
                'customer_name' => 'Mega Permata',
                'phone' => '084455667788',
                'check_in' => Carbon::now()->addDays(16),
                'check_out' => Carbon::now()->addDays(19),
                'total_price' => 1450000,
                'facilities' => ['parkir'],
            ],

            [
                'rooms' => [$rooms[5]->id],
                'customer_name' => 'Nanda Prakoso',
                'phone' => '085566778899',
                'check_in' => Carbon::now()->addDays(17),
                'check_out' => Carbon::now()->addDays(20),
                'total_price' => 2150000,
                'facilities' => ['makan', 'wifi'],
            ],

            [
                'rooms' => [$rooms[6]->id],
                'customer_name' => 'Olivia Maharani',
                'phone' => '086677889900',
                'check_in' => Carbon::now()->addDays(18),
                'check_out' => Carbon::now()->addDays(21),
                'total_price' => 2800000,
                'facilities' => ['wifi', 'parkir'],
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
                'status' => 'booked'
            ]);

            // Simpan pivot
            $reservation->rooms()->attach($data['rooms']);

            // Update status kamar
            Room::whereIn('id', $data['rooms'])->update([
                'status' => 'booked'
            ]);
        }
    }
}
