<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string',
            'username' => 'required|string'
        ]);
        if (!auth()->attempt([
            "password" => htmlspecialchars(trim($request->password)),
            "username" => htmlspecialchars(trim(strtolower(($request->username))))
        ])) {
            return back()->with('pesan', 'Data Tidak Valid');
        }
        $data = auth()->user();
        if ($data->status_aktif === 'tidak') {
            return back()->with('pesan', 'Akun Kamu Belum Aktif');
        }
        return redirect()->route('dashboard');
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
