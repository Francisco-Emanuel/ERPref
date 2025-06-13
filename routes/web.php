<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtivoTIController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::prefix('Ativos')->group(function () {

    // Listar todos os ativos
    Route::get('/', [AtivoTIController::class, 'showAll'])->name('Ativos.index');
    
    Route::get('/hidden', [AtivoTIController::class, 'showHidden'])->name('Ativos.hidden');

    // Formulário para criar um novo ativo
    Route::get('/criar', function () {
        return view('ativos.create');
    })->name('Ativos.criar');

    // Registrar um novo ativo (envio do formulário)
    Route::post('/criar', [AtivoTIController::class, 'store'])->name('Ativos.store');

    // Formulário para editar um ativo específico
    Route::get('/{id}/editar', [AtivoTIController::class, 'edit'])->name('Ativos.edit');

    // Atualizar o ativo
    Route::put('/{id}', [AtivoTIController::class, 'update'])->name('Ativos.update');

    // Ocultar o ativo
    Route::delete('/{id}', [AtivoTIController::class, 'delete'])->name('Ativos.delete');
    
    // Desocultar o ativo
    Route::put('/hidden/{id}', [AtivoTIController::class, 'redo'])->name('Ativos.redo');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
