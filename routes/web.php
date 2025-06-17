<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtivoTIController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\DashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('home');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('ativos/trash', [AtivoTiController::class, 'trash'])->name('ativos.trash')->middleware('auth');
Route::patch('ativos/{id}/restore', [AtivoTiController::class, 'restore'])->name('ativos.restore')->middleware('auth');

Route::resource('ativos', AtivoTiController::class)->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('setores', SetorController::class);
});

require __DIR__ . '/auth.php';
