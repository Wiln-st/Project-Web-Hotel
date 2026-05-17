<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function rooms()
    {
        $rooms = Room::with('roomType')->orderBy('room_number', 'asc')->get();
        $types = RoomType::all();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'tersedia')->count();
        $fullRooms = Room::where('status', 'penuh')->count();
        $bookedRooms = Room::where('status', 'dipesan')->count();
        $maintenanceRooms = Room::where('status', 'pemeliharaan')->count();
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
            'status' => 'tersedia',
        ]);

        return back()->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return back()->with('success', 'Kamar berhasil dihapus.');
    }
}
