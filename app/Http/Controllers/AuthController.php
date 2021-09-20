<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register (RegisterRequest $request) {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $token = Auth::login($user);

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
    public function login(Request $request){
        $credentials = $request->only(['email', 'password']);
        $token = Auth::attempt($credentials);

        if(!$token){
            return response()->json([
                'message' => 'Invalid credentials'
            ],401);
        }

        return response()->json([
            'token' => $token,
            'user' => Auth::user()
        ]);
    }
    public function logout(){
        Auth::logout();
        return response()->noContent();
    }

    public function getMyProfile(){
        $user = Auth::user();
        return response()->json($user);
    }

    public function refreshToken(){
        try{
            $token = Auth::refresh();
            return [
                'token' => $token
            ];
        }catch (TokenBlacklistedException $exception){
            return response()->json([
                'message' => 'Token is invalid'
            ],401);
        }
    }

}



