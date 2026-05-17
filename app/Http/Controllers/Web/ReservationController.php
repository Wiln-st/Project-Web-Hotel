<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function store(Request $request){
        $request->validate([
            'customer_name' => 'required',
            'phone' => 'required',
            'room_id' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
        ]);

        $roomIds = is_array($request->room_id) ? $request->room_id : [$request->room_id];

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
                if ($facility == 'makan') {
                    $facilitiesTotal += 75000;
                } elseif ($facility == 'parkir') {
                    $facilitiesTotal += 10000;
                } elseif ($facility == 'wifi') {
                    $facilitiesTotal += 0;
                }
            }
        }

        foreach ($roomIds as $roomId) {
            $room = Room::with('roomType')->findOrFail($roomId);
            $totalPrice = ($room->roomType->price * $days) + ($facilitiesTotal * $days);

            Reservation::create([
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'room_id' => $roomId,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'total_price' => $totalPrice,
                'facilities' => $facilities,
            ]);

            $room->update([
                'status' => 'dipesan'
            ]);
        }

        return back()->with('success', 'Reservasi berhasil dibuat.');
    }
}
