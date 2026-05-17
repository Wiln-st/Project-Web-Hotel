<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{


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
