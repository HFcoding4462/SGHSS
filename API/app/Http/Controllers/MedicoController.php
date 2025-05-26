<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\MedicoService;
use App\Models\User;
use App\Http\Requests\StoreMedicoRequest;
use App\Http\Requests\UpdateMedicoRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class MedicoController extends Controller
{
    protected $medicoService;

    public function __construct() {
        $this->medicoService = new MedicoService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicos = $this->medicoService->all();

        if (!$medicos) {
            return response()->json(['mensagem' => 'Nenhum medico encontrado!'], 404);
        }

        return response()->json($medicos->toArray(), 200); 
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicoRequest $request)
    {
        $atributos = $request->validated();
        $user = $this->medicoService->store($atributos);
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'mensagem' => 'Medico criado com sucesso - ID: ' . $user->id,
            'token' => $token
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $medico)
    {
        if (!$medico) {
            return response()->json(['mensagem' => 'Medico nao encontrado'], 404);
        }

        return response()->json($medico->toArray(), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicoRequest $request, User $medico)
    {
        $atributos = $request->validated();
        $medicoAtualizado = $this->medicoService->update($medico, $atributos);

        return response()->json(['mensagem' => "Medico #$medicoAtualizado->id atualizado com sucesso"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $medico)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user->can('delete', $medico);

        $this->medicoService->destroy($medico);
        return response()->json([], 200);
    }

    public function me() 
    {
        $medico = $this->medicoService->me();
        
        if (!$medico) {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json(['mensagem' => "Conta atual é um $user->role e não um medico."], 404);
        }

        return response()->json($medico->toArray(), 200);
    }
}
