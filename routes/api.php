<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\AdminController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::post('/paciente', [PacienteController::class, 'store']);

Route::middleware('auth:api')->group(function() {
    Route::get('/pacientes', [PacienteController::class, 'index']);
    Route::get('/paciente/{id}', [PacienteController::class, 'show']);
});