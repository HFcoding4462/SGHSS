<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PacienteService;
use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use App\Models\User;

class PacienteController extends Controller
{
    protected $pacienteService;

    public function __construct() {
        $this->pacienteService = new PacienteService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = $this->pacienteService->all();

        if (!$pacientes) {
            return response()->json(['mensagem' => 'Nenhum usuario encontrado!'], 404);
        }

        return response()->json($pacientes->toArray(), 200); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePacienteRequest $request)
    {
        $atributos = $request->validated();
        $paciente = $this->pacienteService->store($atributos);
 
        $token = JWTAuth::fromUser($paciente);

        return response()->json([
            'mensagem' => "Paciente #$paciente->id criado com sucesso.",
            'token' => $token
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $paciente)
    {
        if (!$paciente) {
            return response()->json(['mensagem' => 'Paciente nao encontrado'], 404);
        }

        return response()->json($paciente->toArray(), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request, User $paciente)
    {
        $atributos = $request->validated();
        $pacienteAtualizado = $this->pacienteService->update($paciente, $atributos);

        return response()->json(['mensagem' => "Paciente #$pacienteAtualizado->id atualizado com sucesso"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $paciente)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user->can('delete', $paciente);

        $this->pacienteService->destroy($paciente);
        return response()->json([], 200);
    }

    public function me() 
    {
        $paciente = $this->pacienteService->me();
        
        if (!$paciente) {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json(['mensagem' => "Conta atual é um $user->role e não um paciente."], 404);
        }

        return response()->json($paciente->toArray(), 200);
    }
}
