<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index(Request $request)
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
        return view('admin.rooms', compact(
            'rooms',
            'types',
            'totalRooms',
            'availableRooms',
            'fullRooms',
            'bookedRooms',
            'maintenanceRooms'
        ));
    }

    public function store(Request $request)
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

    public function destroy($id)
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

    public function update(Request $request, Room $room)
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
