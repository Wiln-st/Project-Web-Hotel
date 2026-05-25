<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OwnerController extends Controller
{

    //DASHBOARD
    public function dashboard()
    {
        $today = Carbon::now();

        // Total pemasukan
        $totalIncome = Transaction::where('type', 'pemasukan')->sum('amount');

        // Total pengeluaran
        $totalExpense = Transaction::where('type', 'pengeluaran')->sum('amount');

        // Saldo akhir
        $totalBalance = $totalIncome - $totalExpense;

        // Pagination transaksi terbaru
        $transactions = Transaction::latest()->paginate(5);

        return view('owner.dashboard', compact(
            'today',
            'totalIncome',
            'totalExpense',
            'totalBalance',
            'transactions'
        ));
    }

    public function store_transaction(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        Transaction::create([
            'type' => $request->type,
            'title' => $request->description,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'type' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        $transaction->update([
            'type' => $request->type,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus');
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

        return view('owner.history', compact(
            'reservations',
            'totalReservations',
            'totalIncome',
            'search'
        ));
    }


    //MANAGE EMPLOYEE

    public function user()
    {

        $employees = User::Where('role', 'employee', 'supervisor')->latest()->get();

        return view('owner.manage_employee', compact('employees'));
    }

    //NOTFIKASI
    public function notifications()
    {
        return view('owner.notifikasi');
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
        return view('owner.rooms', compact(
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
