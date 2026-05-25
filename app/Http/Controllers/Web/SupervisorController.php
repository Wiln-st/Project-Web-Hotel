<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SupervisorController extends Controller
{

    //MANAGE EMPLOYEE
    public function user()
    {

        $employees = User::Where('role', 'employee')->latest()->get();

        return view('supervisor.manage_employee', compact('employees'));
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
            'status' => 'active',
        ]);

        return back()->with('success', 'Berhasil menambahkan karaywan');
    }

    public function destroy_user($id)
    {
        $employee = User::findOrFail($id);

        $employee->delete();

        return back()->with('success', 'Berhasil menghapus karyawan');
    }

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

        return view('supervisor.history', compact(
            'reservations',
            'totalReservations',
            'totalIncome',
            'search'
        ));
    }

    public function destroy_reservation($id)
    {
        $reservation = Reservation::findOrFail($id);

        Room::whereIn('id', $reservation->rooms->pluck('id'))
            ->update(['status' => 'available']);

        $reservation->delete();

        return back()->with('success', 'Reservasi berhasil dihapus.');
    }



    //NOTIFIKASI
    public function notification()
    {
        $notifications = Notification::latest()->get();

        return view('supervisor.notifikasi', compact('notifications'));
    }

    public function clearAll()
    {
        Notification::truncate();
        return back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }

    public function destroy_notification($id)
    {
        $notification = Notification::findOrFail($id)->delete();
        return back()->with('success', 'Notification berhasil dihapus.');
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
        return view('supervisor.rooms', compact(
            'rooms',
            'types',
            'totalRooms',
            'availableRooms',
            'fullRooms',
            'bookedRooms',
            'maintenanceRooms'
        ));
    }

    public function room_store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number',
            'room_type_id' => 'required|exists:room_types,id',
        ]);

        Room::create([
            'room_number' => $request->room_number,
            'room_type_id' => $request->room_type_id,
            'status' => 'available',
        ]);

        return back()->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function room_destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return back()->with('success', 'Kamar berhasil dihapus.');
    }

    public function updateStatus(Request $request, Room $room)
    {
        $request->validate([
            'status' => 'required|in:available,maintenance,occupied'
        ]);

        $room->update([
            'status' => $request->status
        ]);
        return back()->with('success', 'Status kamar berhasil diupdate');
    }

    public function room_update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => [
                'required',
                'numeric',
                Rule::unique('rooms', 'room_number')->ignore($room->id),
            ],

            'room_type_id' => 'required',
            'status' => 'required',
        ], [
            'room_number.unique' => 'Nomor kamar sudah digunakan!',
        ]);

        $room->update([
            'room_number' => $request->room_number,
            'room_type_id' => $request->room_type_id,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Kamar berhasil diupdate');
    }
}
