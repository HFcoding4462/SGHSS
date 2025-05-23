<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class PacienteController extends Controller
{
    protected $userService;

    public function __construct() {
        $this->userService = new UserService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $atributos = $request->validated();
        $user = $this->userService->store($atributos);

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Algo inesperado aconteceu, por favor entre em contato com o suporte!'], 500);
        }

        return response()->json([
            'mensagem' => 'Usuário criado com sucesso - ID: ' . $user->id,
            'token' => $token
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = $this->userService->find($id);
            
            if (!$user) {
                throw new Exception("Usuário não encontrado.");
            }

            return response()->json($user->toArray(), 200);
        } catch (Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function me() {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json($user->toArray(), 200);
    }
}
