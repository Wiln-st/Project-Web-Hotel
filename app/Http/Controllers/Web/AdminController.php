<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
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
