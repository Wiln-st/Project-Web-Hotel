<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //HISTORY

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

            ->paginate(7)

            ->withQueryString();

        $totalReservations = Reservation::count();

        $totalIncome = Reservation::sum('total_price');

        return view('employee.history', compact(
            'reservations',
            'totalReservations',
            'totalIncome',
            'search'
        ));
    }

    //NOTIFIKASI
    public function notification()
    {
        $notifications = Notification::latest()->get();

        return view('employee.notifikasi', compact('notifications'));
    }

    public function destroy_notification($id)
    {
        $notification = Notification::findOrFail($id)->delete();
        return back()->with('success', 'Notification berhasil dihapus.');
    }

    public function clearAll()
    {
        Notification::truncate();
        return back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }

    public function refresh_notification()
    {
        $today = now()->toDateString();

        $reservations = Reservation::whereDate('check_in', $today)
            ->where('status', 'booked')
            ->get();

        foreach ($reservations as $reservation) {
            $exist = Notification::where('type', 'check_in')
                ->where('reservation_id', $reservation->id)
                ->exists();

            if (!$exist) {
                Notification::create([
                    'type' => 'check_in',
                    'title' => 'Check-in Hari Ini',
                    'message' => "Reservasi dengan nama {$reservation->customer_name} dijadwalkan untuk check-in hari ini.",
                    'reservation_id' => $reservation->id,
                ]);
            }
        }

        $reservations = Reservation::whereDate('check_out', $today)
            ->where('status', 'check_in')
            ->get();

        foreach ($reservations as $reservation) {
            $exist = Notification::where('type', 'check_out')
                ->where('reservation_id', $reservation->id)
                ->exists();

            if (!$exist) {
                Notification::create([
                    'type' => 'check_out',
                    'title' => 'Check-out Hari Ini',
                    'message' => "Reservasi dengan nama {$reservation->customer_name} dijadwalkan untuk check-out hari ini.",
                    'reservation_id' => $reservation->id,
                ]);
            }
        }

        return back();
    }

    public function checkIn_notification(Notification $notification)
    {

        $reservation = $notification->reservation;

        if (!$reservation) {
            return back()->with('error', 'Reservasi tidak ditemukan.');
        }

        $reservation->rooms()->update([
            'status' => 'occupied'
        ]);

        $reservation->update(['status' => 'check_in']);

        $notification->delete();

        return back()->with('success', 'Customer berhasil check-in');
    }

    public function checkOut_notification(Notification $notification)
    {
        $reservation = $notification->reservation;

        if (!$reservation) {
            return back()->with('error', 'Reservasi tidak ditemukan.');
        }

        Room::whereIn(
            'id',
            $reservation->rooms->pluck('id')
        )->update(['status' => 'available']);

        $reservation->update(['status' => 'check_out']);

        $notification->delete();

        return back()->with('success', 'Customer berhasil check-out');
    }

    //RESERVATION
    public function reservation()
    {
        $roomTypes = RoomType::with(['rooms' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        $rooms = Room::with('roomType')->where('status', 'available')->get();

        return view('employee.reservations', compact('roomTypes', 'rooms'));
    }

    public function store_reservation(Request $request)
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

    public function destroy_reservation($id)
    {
        $reservation = Reservation::findOrFail($id);

        Room::whereIn('id', $reservation->rooms->pluck('id'))
            ->update(['status' => 'available']);

        $reservation->delete();

        return back()->with('success', 'Reservasi berhasil dihapus.');
    }

    public function edit_reservation($id)
    {
        $reservation = Reservation::with('rooms')->findOrFail($id);
        $roomTypes = RoomType::with(['rooms' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        return view('employee.reservations_edit', compact('reservation', 'roomTypes'));
    }

    public function update_reservation(Request $request, $id)
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
                'status' => 'booked'
            ]);

        return redirect()
            ->route('employee.reservations.history')
            ->with('success', 'Reservasi berhasil diupdate.');
    }

    public function checkIn_reservation(Reservation $reservation)
    {
        Notification::create([
            'type' => 'check_in',
            'title' => 'Customer Check-in',
            'message' => "Tamu telah melakukan check-in.",
            'reservation_id' => $reservation->id,
        ]);
    }

    public function checkOut_reservation(Reservation $reservation)
    {
        Notification::create([
            'type' => 'check_out',
            'title' => 'Customer Check-out',
            'message' => "Tamu telah melakukan check-out.",
            'reservation_id' => $reservation->id,
        ]);
    }

    public function roomSystem_reservation()
    {
        Notification::create([
            'type' => 'room_system',
            'title' => 'Pemberitahuan Sistem Kamar',
            'message' => "Sistem kamar telah melakukan pembaruan status.",
        ]);
    }

    //ROOM

    public function room(Request $request)
    {
        $query = Room::with('roomType');

        if ($request->kategori) {
            $query->whereHas('roomType', function ($q) use ($request) {
                $q->where('name', $request->kategori);
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $rooms = $query->orderBy('room_number', 'asc')->get();
        $types = RoomType::all();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $fullRooms = Room::where('status', 'occupied')->count();
        $bookedRooms = Room::where('status', 'booked')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();
        return view('employee.rooms', compact(
            'rooms',
            'types',
            'totalRooms',
            'availableRooms',
            'fullRooms',
            'bookedRooms',
            'maintenanceRooms'
        ));
    }
}
