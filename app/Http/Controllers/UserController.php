<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index_user', compact('users'));
    }
    //store membuat data baru
    public function store(Request $request)
    {
        $data = $request->except('_token');
        if ($request->input('checkEmail')) {
            $user = User::where('email', $request->input('email'))->exists();
            return response()->json($user);
        }
        $rule = [
            'nama' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'avatar' => 'mimes:jpg,png,jpeg,gift|max:2000|required'
        ];

        $validate = Validator::make($data, $rule);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ]);
        }
        //buat upload gambar
        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->isValid()) {
                $fileName = time() . '-' . date('M') . '.' . $request->file('avatar')->extension();
                $request->file('avatar')->move(public_path('assets/image/user'), $fileName);
                $data['avatar'] = "assets/image/user/$fileName";
            }
        }
        $data['password'] = Hash::make($request->input('password'));

        $newUser = User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['level'],
            'avatar' => $data['avatar']
        ]);
        if ($newUser) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    //
    public function show($id)
    {
        return response()->json(User::find($id));
    }
    public function update($id, Request $request)
    {
        $user = User::find($id);
        $rule = [
            'nama' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'avatar' => 'mimes:jpg,png,jpeg,gift|max:2000|required'
        ];
        $data = $request->except('_token');
        // $validate = Validator::make($data, $rule);
        // if ($validate->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'errors' => $validate->errors()
        //     ]);
        // }
        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->isValid()) {
                if (file_exists(public_path($user->avatar) && $user->avatar != null)) {
                    unlink(public_path($user->avatar));
                }
                $fileName = time() . '-' . date('M') . '.' . $request->file('avatar')->extension();
                $request->file('avatar')->move(public_path('assets/image/user'), $fileName);
                $data['avatar'] = "assets/image/user/$fileName";
            }
        }
        $user->fill($data);
        if ($user->save()) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);
        unlink($user->avatar);
        if ($user) {
            $user->delete();
            return response()->json(true);
        } else {
            return response()->json(true);
        }
    }
}
