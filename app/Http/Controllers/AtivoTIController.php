<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtivoTI;

class AtivoTIController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'identificacao' => 'required|string|unique:ativos_ti,identificacao|max:255',
            'descricao_problema' => 'required|string',
            'tipo_ativo' => 'required|string|max:255',
            'setor' => 'required|string|max:255',
            'usuario_responsavel' => 'required|string|max:255',
            'status' => 'boolean',
        ]);
        $validatedData['status'] = $request->has('status');

        AtivoTI::create($validatedData);

        return redirect()->route('Ativos.index')->with('success','Ativo criado');
    }

    public function showAll()
    {
        $ativos = AtivoTI::where('visible', true)->orderBy('id', 'desc')->paginate(6);

        return view('ativos.index', compact('ativos'));
    }

    public function showHidden()
    {
        $ativos = AtivoTI::where('visible', false)->orderBy('id', 'desc')->paginate(6);

        return view('ativos.hidden', compact('ativos'));
    }

    public function edit($id)
    {
        $ativo = AtivoTI::findOrFail($id);
        return view('ativos.edit', compact('ativo'));
    }
    public function update(Request $request, $id)
    {
        $ativo = AtivoTI::findOrFail($id);

        $validatedData = $request->validate([
            'identificacao' => 'required|string|max:255|unique:ativos_ti,identificacao,' . $ativo->id,
            'descricao_problema' => 'required|string',
            'tipo_ativo' => 'required|string|max:255',
            'setor' => 'required|string|max:255',
            'usuario_responsavel' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        $validatedData['status'] = $request->has('status');

        $ativo->update($validatedData);

        return redirect()->route('Ativos.index')->with('success','Ativo editado');
    }

    public function delete($id) {
        $ativo = AtivoTI::findOrFail($id);
        $ativo->visible = false;
        $ativo->save();
        return redirect()->route('Ativos.index')->with('success','Ativo ocultado');
    }

    public function redo($id) {
        $ativo = AtivoTI::findOrFail($id);
        $ativo->visible = true;
        $ativo->save();
        return redirect()->route('Ativos.index')->with('success','Ativo desocultado');
    }
}
