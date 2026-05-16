<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function rooms()
    {
        return view('admin.rooms');
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
