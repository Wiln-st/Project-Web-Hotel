<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Notification;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with(['rooms' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        $rooms = Room::with('roomType')->where('status', 'available')->get();

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
            'status' => 'booked'
        ]);

        
        // SIMPAN KE PIVOT
        $reservation->rooms()->attach($request->room_ids);

        Notification::create([
            'type' => 'reservation',
            'title' => 'Reservasi Baru',
            'message' => "{$reservation->customer_name} telah melakukan reservasi kamar.",
            'reservation_id' => $reservation->id,
        ]);

        // UPDATE STATUS KAMAR
        Room::whereIn('id', $request->room_ids)
            ->update([
                'status' => 'booked'
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

        $totalIncome = Reservation::sum('total_price');

        return view('admin.history', compact(
            'reservations',
            'totalReservations',
            'totalIncome',
            'search'
        ));
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        Room::whereIn('id', $reservation->rooms->pluck('id'))
            ->update(['status' => 'available']);

        $reservation->delete();

        return back()->with('success', 'Reservasi berhasil dihapus.');
    }

    public function edit($id)
    {
        $reservation = Reservation::with('rooms')->findOrFail($id);
        $roomTypes = RoomType::with(['rooms' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        return view('admin.reservations_edit', compact('reservation', 'roomTypes'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::with('rooms')->findOrFail($id);

        $request->validate([
            'customer_name' => 'required',
            'phone' => 'required',
            'room_ids' => 'required|array',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
        ]);

        // HITUNG HARI
        $days = Carbon::parse($request->check_in)
            ->diffInDays(Carbon::parse($request->check_out));

        if ($days == 0) {
            $days = 1;
        }

        // HITUNG FASILITAS
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

        // TOTAL KAMAR
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

        // RESET STATUS KAMAR LAMA
        Room::whereIn('id', $reservation->rooms->pluck('id'))
            ->update([
                'status' => 'available'
            ]);

        // UPDATE RESERVASI
        $reservation->update([
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'facilities' => $facilities,
        ]);

        // UPDATE PIVOT
        $reservation->rooms()->sync($request->room_ids);

        // UPDATE STATUS KAMAR BARU
        Room::whereIn('id', $request->room_ids)
            ->update([
                'status' => 'dipesan'
            ]);

        return redirect()
            ->route('reservation.history')
            ->with('success', 'Reservasi berhasil diupdate.');
    }

    public function checkIn(Reservation $reservation){
        Notification::create([
            'type' => 'check_in',
            'title' => 'Customer Check-in',
            'message' => "Tamu telah melakukan check-in.",
            'reservation_id' => $reservation->id,
        ]);
    }

    public function checkOut(Reservation $reservation){
        Notification::create([
            'type' => 'check_out',
            'title' => 'Customer Check-out',
            'message' => "Tamu telah melakukan check-out.",
            'reservation_id' => $reservation->id,
        ]);
    }

    public function roomSystem(){
        Notification::create([
            'type' => 'room_system',
            'title' => 'Pemberitahuan Sistem Kamar',
            'message' => "Sistem kamar telah melakukan pembaruan status.",
        ]);
    }
}
