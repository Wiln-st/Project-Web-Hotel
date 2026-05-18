<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function reservation()
    {
        $roomTypes = RoomType::with('rooms')->get();

        $rooms = Room::with('roomType')->where('status', 'tersedia')->get();

        return view('admin.reservations', compact('roomTypes', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'phone' => 'required',
            'room_ids' => 'required|array',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
        ]);

        // VALIDASI BENTROK
        foreach ($request->room_ids as $roomId) {

            $bentrok = Reservation::whereHas('rooms', function ($query) use ($roomId) {

                $query->where('rooms.id', $roomId);
            })

                ->where(function ($query) use ($request) {

                    $query->whereBetween('check_in', [
                        $request->check_in,
                        $request->check_out
                    ])

                        ->orWhereBetween('check_out', [
                            $request->check_in,
                            $request->check_out
                        ])

                        ->orWhere(function ($q) use ($request) {

                            $q->where('check_in', '<=', $request->check_in)
                                ->where('check_out', '>=', $request->check_out);
                        });
                })

                ->exists();

            if ($bentrok) {

                $room = Room::find($roomId);

                return back()->with(
                    'error',
                    "Kamar {$room->room_number} telah dibooking pada " .
                        Carbon::parse($request->check_in)->format('d/m/Y') . " - " .
                        Carbon::parse($request->check_out)->format('d/m/Y')
                );
            }
        }

        // HITUNG TOTAL
        $days = Carbon::parse($request->check_in)
            ->diffInDays(Carbon::parse($request->check_out));

        if ($days == 0) {
            $days = 1;
        }

        $facilitiesTotal = 0;

        $facilities = $request->facilities ?? [];

        foreach ($facilities as $facility) {

            if ($facility == 'Makan') {
                $facilitiesTotal += 75000;
            } elseif ($facility == 'Parkir') {
                $facilitiesTotal += 5000;
            } elseif ($facility == 'Wifi') {
                $facilitiesTotal += 25000;
            }
        }

        // TOTAL SEMUA KAMAR
        $roomTotal = 0;

        $rooms = Room::with('roomType')
            ->whereIn('id', $request->room_ids)
            ->get();

        foreach ($rooms as $room) {
            $roomTotal += $room->roomType->price;
        }

        $totalPrice =
            ($roomTotal * $days)
            +
            ($facilitiesTotal * $days);

        // BUAT RESERVASI
        $reservation = Reservation::create([
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'facilities' => $facilities,
            'status' => 'booking',
        ]);

        // SIMPAN KE PIVOT
        $reservation->rooms()->attach($request->room_ids);

        // UPDATE STATUS KAMAR
        Room::whereIn('id', $request->room_ids)
            ->update([
                'status' => 'dipesan'
            ]);

        return back()->with(
            'success',
            'Reservasi berhasil dibuat.'
        );
    }

    public function history(Request $request)
    {
        $search = $request->search;

        $reservations = Reservation::with('rooms.roomType')

            ->when($search, function ($query) use ($search) {

                $query->where('customer_name', 'like', "%{$search}%")

                    ->orWhere('phone', 'like', "%{$search}%")

                    ->orWhereHas('rooms', function ($q) use ($search) {

                        $q->where('room_number', 'like', "%{$search}%");
                    })

                    ->orWhereHas('rooms.roomType', function ($q) use ($search) {

                        $q->where('name', 'like', "%{$search}%");
                    });
            })

            ->latest()

            ->get();

        $totalReservations = Reservation::count();

        $activeReservations = Reservation::where('status', 'check_in')
            ->count();

        $totalIncome = Reservation::sum('total_price');

        return view('admin.history', compact(
            'reservations',
            'totalReservations',
            'activeReservations',
            'totalIncome',
            'search'
        ));
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->rooms->update([
            'status' => 'tersedia'
        ]);

        $reservation->delete();

        return back()->with('success', 'Reservasi berhasil dihapus.');
    }
}
