<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        
        if (!Auth::attempt($validatedData)) {
            return response([
                'message' => 'La autenticación ha fallado'
            ], 401);
        }

        $user = Auth::user();
        $access_token = $user->createToken('Auth_token')->accessToken;
        
        return response([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'access_token' => $access_token
        ], 200);
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        $user = User::create($validatedData);
        $access_token = $user->createToken('Auth_token')->accessToken;

        return response([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'access_token' => $access_token
        ], 201);
    }

    public function me()
    {
        $user = Auth::user();
        return response([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }

    public function logout()
    {
        try {
            Auth::user()->tokens()->delete();
            return response([
                'message' => "Ha cerrado sesión correctamente"
            ]);
        } catch (\Throwable $th) {
            return response([
                'error' => $th -> getMessage()
            ], 500);
        }
        
    }
}
