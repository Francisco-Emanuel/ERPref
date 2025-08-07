<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
         $totalChamadosAbertos = Chamado::where('status', 'Aberto')->count();
         $chamadosRecentes = Chamado::with('solicitante')->latest()->take(5)->get();
        
        return view('dashboard', [
            'totalChamadosAbertos' => $totalChamadosAbertos,
            'chamadosRecentes' => $chamadosRecentes,
        ]);
    }
}