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

Route::middleware('auth:api')->prefix('paciente')->group(function() {
    Route::get('/', [PacienteController::class, 'index']);
    Route::get('/me', [PacienteController::class, 'me']);
    Route::get('/{id}', [PacienteController::class, 'show']);
});