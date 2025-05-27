<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Exception;
use App\Models\User;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct() {
        $this->adminService = new AdminService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = $this->adminService->all();

        if (!$admins) {
            return response()->json(['mensagem' => 'Nenhum administrador encontrado!'], 404);
        }

        return response()->json($admins->toArray(), 200); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $atributos = $request->validated();
        $admin = $this->adminService->store($atributos);
 
        $token = JWTAuth::fromUser($admin);

        return response()->json([
            'mensagem' => "Administrador #$admin->id criado com sucesso.",
            'token' => $token
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        if ($user->cannot('view', $admin)) {
            throw new AccessDeniedHttpException();
        }

        if (!$admin) {
            return response()->json(['mensagem' => 'Admin não encontrado'], 404);
        }

        return response()->json($admin->toArray(), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, User $admin)
    {
        $atributos = $request->validated();
        $adminAtualizado = $this->adminService->update($admin, $atributos);

        return response()->json(['mensagem' => "Admin #$adminAtualizado->id atualizado com sucesso"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->cannot('delete', $admin)) {
            throw new AccessDeniedHttpException();
        }

        $this->adminService->destroy($admin);
        return response()->json([], 200);
    }
}
