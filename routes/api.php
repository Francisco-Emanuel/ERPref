<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController; // Importe o NotificationController

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rota padrão para obter detalhes do usuário autenticado via Sanctum
Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

// Rota para obter detalhes de um usuário específico via API (se ainda estiver em uso)
Route::middleware('auth')->get('/user-details/{user}', [UserController::class, 'getUserDetails'])->name('api.user.details');

// Rotas de API para Notificações (ADICIONE ESTE BLOCO)
Route::middleware('auth')->group(function () {
});

