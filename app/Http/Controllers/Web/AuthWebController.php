<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthWebController extends Controller
{
    public function showlogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect('admin/dashboard');

            } elseif (Auth::user()->role === 'employee') {
                return redirect('employee/rooms');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
        
    }
}
