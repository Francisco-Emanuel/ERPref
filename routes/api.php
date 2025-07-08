<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user-details/{user}', [UserController::class, 'getUserDetails'])->name('api.user.details');

    // Rota para buscar todas as notificações do usuário logado (lidas e não lidas)
    Route::get('/notifications', function (Request $request) {
        return response()->json([
            'notifications' => $request->user()->notifications,
            'unreadCount' => $request->user()->unreadNotifications->count()
        ]);
    });

    // Rota para buscar apenas a contagem de notificações não lidas
    Route::get('/notifications/count', function (Request $request) {
        return response()->json(['count' => $request->user()->unreadNotifications->count()]);
    });

    // Rota para marcar todas as notificações não lidas como lidas
    Route::post('/notifications/mark-as-read', function (Request $request) {
        $request->user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
    });

    // Rota para marcar uma notificação específica como lida (opcional, para clique individual)
    Route::patch('/notifications/{id}/mark-as-read', function (Request $request, $id) {
        $notification = $request->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'message' => 'Notificação não encontrada'], 404);
    });
});
