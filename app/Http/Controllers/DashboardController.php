<?php

namespace App\Http\Controllers;

use App\Models\AtivoTI;
use App\Models\Chamado;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAtivos = AtivoTI::count();
        $ativosDefeituosos = AtivoTI::where('status_condicao', 'Defeituoso')->count();

         $totalChamadosAbertos = Chamado::where('status', 'Aberto')->count();
         $chamadosRecentes = Chamado::with('solicitante')->latest()->take(5)->get();
        
        return view('dashboard', [
            'totalAtivos' => $totalAtivos,
            'ativosDefeituosos' => $ativosDefeituosos,
            'totalChamadosAbertos' => $totalChamadosAbertos,
            'chamadosRecentes' => $chamadosRecentes,
        ]);
    }
}