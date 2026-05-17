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
        $types = RoomType::all();

        $rooms = Room::with('roomType')->where('status', 'tersedia')->get();

        return view('admin.reservations', compact('types', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'phone' => 'required',
            'room_id' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
        ]);

        $room = Room::with('roomType')->findOrFail($request->room_id);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        $days = $checkIn->diffInDays($checkOut);

        if ($days == 0) {
            $days = 1;
        }

        $facilitiesTotal = 0;

        $facilities = $request->facilities ?? [];

        if ($request->has('facilities')) {
            $facilities = $request->facilities;
            foreach ($facilities as $facility) {
                if ($facility == 'Makan') {
                    $facilitiesTotal += 75000;
                } elseif ($facility == 'Parkir') {
                    $facilitiesTotal += 5000;
                } elseif ($facility == 'Wifi') {
                    $facilitiesTotal += 25000;
                }
            }
        }

        $totalPrice = ($room->roomType->price * $days) + ($facilitiesTotal * $days);

        Reservation::create([
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'facilities' => $facilities,
        ]);

        $room->update([
            'status' => 'dipesan'
        ]);

        return back()->with('success', 'Reservasi berhasil dibuat.');
    }

    public function history(Request $request)
    {
        $search = $request->search;

        $reservations = Reservation::with('room.roomType')

            ->when($search, function ($query) use ($search) {

                $query->where('customer_name', 'like', "%{$search}%")

                    ->orWhere('phone', 'like', "%{$search}%")

                    ->orWhereHas('room', function ($q) use ($search) {

                        $q->where('room_number', 'like', "%{$search}%");
                    })

                    ->orWhereHas('room.roomType', function ($q) use ($search) {

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

        $reservation->room->update([
            'status' => 'tersedia'
        ]);

        $reservation->delete();

        return back()->with('success', 'Reservasi berhasil dihapus.');
    }
}
