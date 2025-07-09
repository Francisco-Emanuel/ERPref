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
Route::middleware(['auth', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

// Rota para obter detalhes de um usuário específico via API (se ainda estiver em uso)
Route::middleware('auth:sanctum')->get('/user-details/{user}', [UserController::class, 'getUserDetails'])->name('api.user.details');

// Rotas de API para Notificações (ADICIONE ESTE BLOCO)
Route::middleware(['auth', 'verified'])->group(function () {
    // Rota para buscar todas as notificações do usuário logado (lidas e não lidas)
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('api.notifications.all');

    // Rota para buscar apenas a contagem de notificações não lidas
    Route::get('/notifications/count', [NotificationController::class, 'getUnreadCount'])->name('api.notifications.count');

    // Rota para marcar todas as notificações não lidas como lidas
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAllAsRead'])->name('api.notifications.markAllAsRead');

    // Rota para marcar uma notificação específica como lida
    Route::patch('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('api.notifications.markAsRead');
});

