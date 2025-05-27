<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\AdminController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::post('/paciente', [PacienteController::class, 'store']);

Route::middleware('auth:api')->get('/pacientes', [PacienteController::class, 'index']);
Route::middleware('auth:api')->prefix('paciente')->group(function() {
    Route::get('/', [PacienteController::class, 'me']);
    Route::put('/{paciente}', [PacienteController::class, 'update']);
    Route::get('/{paciente}', [PacienteController::class, 'show']);
    Route::delete('/{paciente}', [PacienteController::class, 'destroy']);
});


Route::middleware('auth:api')->get('/medicos', [MedicoController::class, 'index']);
Route::middleware('auth:api')->prefix('medico')->group(function() {
    Route::get('/', [MedicoController::class, 'me']);
    Route::post('/', [MedicoController::class, 'store']);
    Route::put('/{medico}', [MedicoController::class, 'update']);
    Route::get('/{medico}', [MedicoController::class, 'show']);
    Route::delete('/{medico}', [MedicoController::class, 'destroy']);
});


Route::middleware('auth:api')->get('/consultas', [ConsultaController::class, 'index']);
Route::middleware('auth:api')->prefix('consulta')->group(function() {
    Route::post('/', [ConsultaController::class, 'store']);
    Route::get('/{consulta}', [ConsultaController::class, 'show']);
    Route::put('/{consulta}', [ConsultaController::class, 'update']);
    Route::delete('/{consulta}', [ConsultaController::class, 'destroy']);
});


Route::middleware('auth:api')->get('/administradores', [AdminController::class, 'index']);
Route::middleware('auth:api')->prefix('administrador')->group(function() {
    Route::post('/', [AdminController::class, 'store']);
    Route::put('/{admin}', [AdminController::class, 'update']);
    Route::get('/{admin}', [AdminController::class, 'show']);
    Route::delete('/{admin}', [AdminController::class, 'destroy']);
});