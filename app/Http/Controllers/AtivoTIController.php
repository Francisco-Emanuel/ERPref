<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtivoTI;

class AtivoTIController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'identificacao' => 'required|string|unique:ativos_ti,patrimonio|max:255',
        'descricao_problema' => 'required|string',
        'tipo_ativo' => 'required|string|max:255',
        'setor' => 'required|string|max:255',
        'usuario_responsavel' => 'required|string|max:255',
        'status' => 'boolean',
        ]);
        $validatedData['status'] = $request->has('status');

        AtivoTI::create($validatedData);

        return redirect()->route('dashboard');
    }

    public function showAll() {
        $ativos = AtivoTI::all();

        return view('ativos', compact('ativos'));
    }
}
