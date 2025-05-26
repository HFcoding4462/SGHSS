<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Services\ConsultaService;
use App\Http\Requests\StoreConsultaRequest;
use App\Http\Requests\UpdateConsultaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    protected $consultaService;

    public function __construct() {
        $this->consultaService = new ConsultaService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultas = $this->consultaService->all();

        if (!$consultas) {
            return response()->json(['mensagem' => 'Nenhuma consulta encontrado!'], 404);
        }

        return response()->json($consultas->toArray(), 200); 
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConsultaRequest $request)
    {
        $atributos = $request->validated();
        $consulta = $this->consultaService->store($atributos);

        return response()->json([
            'mensagem' => "Consulta #{$consulta->id} criada com sucesso"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Consulta $consulta)
    {        
        if (!$consulta) {
            return response()->json(['mensagem' => 'Consulta nao encontrada'], 404);
        }

        return response()->json($consulta->toArray(), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsultaRequest $request, Consulta $consulta)
    {
        $atributos = $request->validated();
        $consultaAtualizado = $this->consultaService->update($consulta, $atributos);

        return response()->json(['mensagem' => "Consulta #$consultaAtualizado->id atualizada com sucesso"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consulta $consulta)
    {
        $user = Auth::user();
        $user->can('delete', $consulta);

        $this->consultaService->destroy($consulta);
        return response()->json([], 200);
    }
}
