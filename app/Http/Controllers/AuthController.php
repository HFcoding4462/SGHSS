<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTExcept;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Credenciais invalidas!'], 401);
        }

        return response()->json([
            'token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 300, //5h
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([], 200);
    }
}