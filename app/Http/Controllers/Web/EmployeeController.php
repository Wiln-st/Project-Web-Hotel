<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {

        $employees = User::Where('role', 'employee')->latest()->get();

        return view('admin.manage_employee',compact('employees'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'password'=>Hash::make($request->pasword),
            'role' => 'employee',
            'status'=>'active',
        ]);

        return back()->with('success','Berhasil menambahkan karaywan');
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);

        $employee->delete();

        return back()->with('success','Berhasil menghapus karyawan');
    }
}
