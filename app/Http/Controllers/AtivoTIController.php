<?php

namespace App\Http\Controllers;

use App\Models\AtivoTI;
use App\Models\Setor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AtivoTiController extends Controller
{
    /**
     * Exibe uma lista de todos os ativos (não deletados).
     */
    public function index()
    {
        // Eager Loading com 'with()' para evitar múltiplas consultas ao banco
        $ativos = AtivoTI::with(['responsavel', 'setor'])->orderBy('id', 'desc')->paginate(10);
        return view('ativos.index', compact('ativos'));
    }

    /**
     * Mostra o formulário para criar um novo ativo.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $setores = Setor::orderBy('name')->get();
        return view('ativos.create', compact('users', 'setores'));
    }

    /**
     * Salva o novo ativo no banco de dados.
     */
    public function store(Request $request)
    {
        // Validação com base na sua nova estrutura de tabela
        $validatedData = $request->validate([
            'nome_ativo' => 'required|string|max:255',
            'numero_serie' => 'required|string|max:255|unique:ativos_ti,numero_serie',
            'tipo_ativo' => 'required|string|max:50',
            'status_condicao' => 'required|string|max:50',
            'descricao_problema' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'setor_id' => 'required|exists:setores,id',
        ]);

        AtivoTI::create($validatedData);

        return redirect()->route('ativos.index')->with('success', 'Ativo cadastrado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um ativo existente.
     * O Laravel automaticamente encontra o ativo pelo ID na URL (Route-Model Binding).
     */
    public function edit(AtivoTI $ativo)
    {
        $users = User::orderBy('name')->get();
        $setores = Setor::orderBy('name')->get();
        return view('ativos.edit', compact('ativo', 'users', 'setores'));
    }

    /**
     * Atualiza o ativo no banco de dados.
     */
    public function update(Request $request, AtivoTI $ativo)
    {
        $validatedData = $request->validate([
            'nome_ativo' => 'required|string|max:255',
            // Regra 'unique' ajustada para ignorar o próprio ativo na verificação
            'numero_serie' => ['required', 'string', 'max:255', Rule::unique('ativos_ti')->ignore($ativo->id)],
            'tipo_ativo' => 'required|string|max:50',
            'status_condicao' => 'required|string|max:50',
            'descricao_problema' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'setor_id' => 'required|exists:setores,id',
        ]);

        $ativo->update($validatedData);

        return redirect()->route('ativos.index')->with('success', 'Ativo atualizado com sucesso!');
    }

    /**
     * Move o ativo para a lixeira (soft delete).
     */
    public function destroy(AtivoTI $ativo)
    {
        $ativo->delete(); // Laravel automaticamente preenche 'deleted_at'
        return redirect()->route('ativos.index')->with('success', 'Ativo movido para a lixeira!');
    }

    public function show(AtivoTI $ativo)
    {
        // Apenas precisamos retornar uma view e passar o ativo para ela.
        return view('ativos.show', compact('ativo'));
    }

    // --- MÉTODOS ADICIONAIS PARA GERENCIAR A LIXEIRA ---

    /**
     * Exibe os ativos que estão na lixeira.
     */
    public function trash()
    {
        $ativos = AtivoTI::onlyTrashed()->with(['responsavel', 'setor'])->orderBy('id', 'desc')->paginate(10);
        return view('ativos.trash', compact('ativos')); // Você precisará criar a view trash.blade.php
    }

    /**
     * Restaura um ativo da lixeira.
     */
    public function restore($id)
    {
        $ativo = AtivoTI::onlyTrashed()->findOrFail($id);
        $ativo->restore(); // Laravel automaticamente define 'deleted_at' como NULL
        return redirect()->route('ativos.trash')->with('success', 'Ativo restaurado com sucesso!');
    }
}