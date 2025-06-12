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

Route::get('/criarAtivo', function () {
    return view('registrarAtivo');
})->name('criarAtivo');

Route::post('/registrarAtivo', [AtivoTIController::class, 'store'])->name('registrarAtivo');

Route::get('/Ativos', [AtivoTIController::class, 'showAll'])->name('Ativos');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
