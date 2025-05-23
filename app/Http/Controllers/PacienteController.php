<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;

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
        $attr = $request->only(['name', 'cpf', 'idade', 'sexo_id', 'email', 'password']);
        dd($attr);
        $user = $this->userService->store($request->toArray());

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Algo inesperado aconteceu, por favor entre em contato com o suporte!'], 500);
        }

        return response()->json(['token' => $token], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = $this->userService->find($id);
            
            if (!$user) {
                throw new Exception("Usuario nao encontrado");
            }

            return $user;
        } catch (Exception $e) {
            return response()->json(['error' => 'Nao foi possivel encontrar o usuario!'], 404);
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
}
