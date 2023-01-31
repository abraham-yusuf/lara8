<?php

namespace App\Http\Controllers;

// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }
    // public function store(Request $request)
    // {
    //     $data = $request->except('_token');
    //     if ($request->input('checkEmail')) {
    //         $user = User::where('email', $request->input('email'))->exists();
    //         return response()->json($user);
    //     }
    //     $rule = [
    //         'nama' => 'required|string',
    //         'kecamatan' => 'required|string',
    //         'kabupaten' => 'required|string',
    //         'provinsi' => 'required|string',
    //         'kode_pos' => 'required|integer',
    //         'nomer_hp' => 'required|string',
    //         'jenis_kelamin' => 'required|string',
    //         'email' => 'required|email',
    //         'password' => 'required|confirmed',
    //         'avatar' => 'mimes:jpg,png,jpeg,gift|max:2000|required'
    //     ];
    //     $validate = Validator::make($data, $rule);
    //     if ($validate->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'errors' => $validate->errors()
    //         ]);
    //     }
    //     if ($request->hasFile('avatar')) {
    //         if ($request->file('avatar')->isValid()) {
    //             $fileName = time() . '-' . date('M') . '.' . $request->file('avatar')->extension();
    //             $request->file('avatar')->move(public_path('foto/users'), $fileName);
    //             $data['avatar'] = $fileName;
    //         }
    //     }
    //     $data['password'] = Hash::make($request->input('password'));
    //     $kab = explode('-', $data['kabupaten']);
    //     $prov = explode('-', $data['provinsi']);
    //     DB::beginTransaction();
    //     try {
    //         $newUser = User::create([
    //             'nama' => $data['nama'],
    //             'jenis_kelamin' => $data['jenis_kelamin'],
    //             'email' => $data['email'],
    //             'password' => $data['password'],
    //             'role' => 'user',
    //             'avatar' => $data['avatar']
    //         ]);
    //         $newaddress = AlamatUser::create([
    //             'users_id' => $newUser->id,
    //             'kecamatan' => $data['kecamatan'],
    //             'kabupaten' => $kab[1],
    //             'kab_id'    => $kab[0],
    //             'kode_pos'  => $data['kode_pos'],
    //             'provinsi'  => $prov[1],
    //             'prov_id'  => $prov[0],
    //             'nomer_hp'  => $data['nomer_hp']
    //         ]);
    //         DB::commit();
    //         auth()->attempt($request->only('email', 'password'));
    //         return response()->json(true);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(false);
    //     }
    // }
}
