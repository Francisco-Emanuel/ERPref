<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Não se esqueça de importar o controller

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ADICIONE ESTA ROTA
Route::middleware('auth:sanctum')->get('/user-details/{user}', [UserController::class, 'getUserDetails'])->name('api.user.details');