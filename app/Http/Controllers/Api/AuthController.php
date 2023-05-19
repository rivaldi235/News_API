<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //registrasi
    public function register(Request $request)
    {

        //simpan user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Success'
        ], 200);
    }

    //login
    public function login(Request $request)
    {
        //cek username dan password
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => false,
                'message' => 'username and or password is invalid'
            ], 400);
        }

        $token = Auth::user()->createToken('authToken')->accessToken;

        return response()->json([
            'status' => true,
            'message' => 'Anda berhasil login',
            'user' => Auth::user(),
            'token' => $token
        ], 200);
    }

    public function profile()
    {
        return response()->json([
            'status' => true,
            'message' => 'Berhasil cek profile',
            'user' => Auth::user()
        ], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            'status' => true,
            'message' => 'berhasil logout'
        ], 200);
    }
}
