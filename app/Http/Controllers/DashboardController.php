<?php

namespace App\Http\Controllers;

use App\Models\AtivoTI;
use App\Models\Chamado;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas dos Ativos
        $totalAtivos = AtivoTI::count();
        $ativosDefeituosos = AtivoTI::where('status_condicao', 'Defeituoso')->count();

        // --- DADOS DOS CHAMADOS (ADICIONAR QUANDO O MÓDULO ESTIVER PRONTO) ---
         $totalChamadosAbertos = Chamado::where('status', 'Aberto')->count();
         $chamadosRecentes = Chamado::with('solicitante')->latest()->take(5)->get();
        
        // Retorna a view com todos os dados
        return view('dashboard', [
            'totalAtivos' => $totalAtivos,
            'ativosDefeituosos' => $ativosDefeituosos,
            'totalChamadosAbertos' => $totalChamadosAbertos,
            'chamadosRecentes' => $chamadosRecentes,
        ]);
    }
}