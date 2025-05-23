<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTExcept;
use App\Services\UserService;
use App\Models\User;

class AuthController extends Controller
{
    protected $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    /*public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        //$attr = $request->only(['name', 'cpf', 'idade', 'sexo_id', 'email', 'password']);
        //$user = $this->userService->store($request->toArray());

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Algo inesperado aconteceu, por favor entre em contato com o suporte!'], 500);
        }

        return response()->json(['token' => $token], 201);
    }*/

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais Invalidas!'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Algo inesperado aconteceu, por favor entre em contato com o suporte!'], 500);
        }

        return response()->json([
            'token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return response()->json(['error' => 'Algo inesperado aconteceu, por favor entre em contato com o suporte!'], 500);
        }

        return response()->json([], 200);
    }

    /*public function getUser()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Usuario nao encontrado'], 404);
            }
            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Algo inesperado aconteceu, por favor entre em contato com o suporte!'], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $user = Auth::user();
            $user->update($request->only(['name', 'email']));
            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Algo inesperado aconteceu, por favor entre em contato com o suporte!'], 500);
        }
    }*/
}