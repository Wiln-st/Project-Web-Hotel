<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Room;
use App\Models\Reservation;

class NotificationController extends Controller
{
    public function notification()
    {
        $notifications = Notification::latest()->get();

        return view('admin.notifikasi', compact('notifications'));
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id)->delete();
        return back()->with('success', 'Notification berhasil dihapus.');
    }

    public function clearAll()
    {
        Notification::truncate();
        return back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }

    public function refreshNotification()
    {
        $today = now()->toDateString();

        $reservations = Reservation::whereDate('check_in', $today)
            ->where('status', 'dipesan')
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

    public function checkIn(Notification $notification)
    {

        $reservation = $notification->reservation;

        if (!$reservation) {
            return back()->with('error', 'Reservasi tidak ditemukan.');
        }

        $reservation->rooms()->update([
            'status'=>'penuh' 
        ]);

        $reservation->update(['status' => 'check_in']);

        $notification->delete();

        return back()->with('success', 'Customer berhasil check-in');
    }

    public function checkOut(Notification $notification)
    {
        $reservation = $notification->reservation;

        if (!$reservation) {
            return back()->with('error', 'Reservasi tidak ditemukan.');
        }

        Room::whereIn(
            'id',
            $reservation->rooms->pluck('id')
        )->update(['status' => 'tersedia']);

        $reservation->update(['status' => 'check_out']);

        $notification->delete();

        return back()->with('success', 'Customer berhasil check-out');
    }
}
