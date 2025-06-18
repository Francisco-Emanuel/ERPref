<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtivoTIController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChamadoController;
use App\Models\User;
use Illuminate\Support\Facades\Route;







Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('ativos/trash', [AtivoTiController::class, 'trash'])->name('ativos.trash');
    Route::patch('ativos/{id}/restore', [AtivoTiController::class, 'restore'])->name('ativos.restore');
    
    
    Route::resource('setores', SetorController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('ativos', AtivoTiController::class);
    Route::resource('chamados', ChamadoController::class)->only(['index', 'create', 'store', 'show']);
    
    Route::post('chamados/{chamado}/updates', [ChamadoController::class, 'addUpdate'])->name('chamados.updates.store');
    
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';
