<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
// Controllers de Gerenciamento
use App\Http\Controllers\AtivoTiController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\ProblemaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota pública principal
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// --- GRUPO DE ROTAS QUE EXIGEM AUTENTICAÇÃO ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas do Perfil (acessível a todos os usuários logados)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- MÓDULOS PRINCIPAIS ---

    // Rotas de Chamados (acessível a mais usuários)
    Route::post('chamados/{chamado}/updates', [ChamadoController::class, 'addUpdate'])->name('chamados.updates.store');
    Route::resource('chamados', ChamadoController::class)->only(['index', 'create', 'store', 'show']);

    // Rotas de Problemas
    Route::resource('problemas', ProblemaController::class)->only(['create', 'store']);

    // --- ROTAS ADMINISTRATIVAS (Protegidas por Cargo) ---
    Route::middleware(['role:Admin|Supervisor'])->group(function () {
        // CRUD de Usuários
        Route::resource('users', UserController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
        
        // CRUD de Setores
        Route::resource('setores', SetorController::class);

        // CRUD de Categorias
        Route::resource('categorias', CategoriaController::class);
    });
    
    // --- ROTAS DE ATIVOS (Controle mais granular pode ser feito com permissões) ---
    // A rota de lixeira e restauração poderia ser protegida por uma permissão específica
    Route::get('ativos/trash', [AtivoTiController::class, 'trash'])->name('ativos.trash');
    // Parâmetro ajustado para {ativo} para consistência
    Route::patch('ativos/{ativo}/restore', [AtivoTiController::class, 'restore'])->name('ativos.restore');
    
    // CRUD de Ativos
    Route::resource('ativos', AtivoTiController::class);

});


// Arquivo com as rotas de login, registro, etc.
require __DIR__.'/auth.php';