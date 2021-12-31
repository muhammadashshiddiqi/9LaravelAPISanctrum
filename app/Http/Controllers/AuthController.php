<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $field = $request->validate([
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $field['name'],
            'email' => $field['email'],
            'password' => bcrypt($field['password'])
        ]);

        $token = $user->createToken($field['name'])->plainTextToken;

        $rest = [
            'message' => 'user telah terdaftar.',
            'user' => $user,
            'token' => $token
        ];

        return response()->json($rest, 201);
    }

    public function login(Request $request)
    {
        $field = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        //check login
        $datauser = User::where('email', $field['email'])->first();
        if(!$datauser || !Hash::check($field['password'], $datauser->password)){
            return response()->json(['message' => 'Email atau password anda salah.'], 401);
        }

        $token = $datauser->createToken($datauser->name)->plainTextToken;

        $rest = [
            'message' => 'user telah login.',
            'user' => $datauser,
            'token' => $token
        ];

        return response()->json($rest, 201);
    }

    public function logout(User $user){
        $iduser = Auth::user()->id;

        DB::table('personal_access_tokens')->where('tokenable_id', $iduser)->delete();

        return response()->json(['message' => 'Logged out'], 205);
    }
}
