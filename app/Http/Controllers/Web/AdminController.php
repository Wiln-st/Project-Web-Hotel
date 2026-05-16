<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function index()
    {
        $rooms = Room::with('roomType')->latest()->get();
        $rooms = Room::orderBy('room_number', 'asc')->get();
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
    public function reservation()
    {
        return view('admin.reservation');
    }
    public function history()
    {
        return view('admin.history');
    }
    public function manageemployee()
    {
        return view('admin.manageemployee');
    }
    public function notifikasi()
    {
        return view('admin.notifikasi');
    }
}
