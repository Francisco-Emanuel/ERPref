<?php

namespace App\Http\Controllers;

use App\Models\AtivoTI;
use App\Models\Chamado; // Adicione o Model de Chamado quando o tiver
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas dos Ativos
        $totalAtivos = AtivoTI::count();
        $ativosDefeituosos = AtivoTI::where('status_condicao', 'Defeituoso')->count();

        // Lista de Ativos Recentes
        $ativosRecentes = AtivoTI::with(['responsavel', 'setor']) // Carrega relacionamentos
                                 ->latest() // Ordena pelos mais novos
                                 ->take(5) // Pega apenas 5
                                 ->get();

        // --- DADOS DOS CHAMADOS (ADICIONAR QUANDO O MÓDULO ESTIVER PRONTO) ---
        // $totalChamadosAbertos = Chamado::where('status', 'Aberto')->count();
        // $chamadosRecentes = Chamado::with('solicitante')->latest()->take(5)->get();
        
        // Retorna a view com todos os dados
        return view('dashboard', [
            'totalAtivos' => $totalAtivos,
            'ativosDefeituosos' => $ativosDefeituosos,
            'ativosRecentes' => $ativosRecentes,
            // 'totalChamadosAbertos' => $totalChamadosAbertos,
            // 'chamadosRecentes' => $chamadosRecentes,
        ]);
    }
}