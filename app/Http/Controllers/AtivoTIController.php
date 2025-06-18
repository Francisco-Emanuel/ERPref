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
     * Exibe a lista de ativos.
     * Graças ao Trait SoftDeletes no Model, esta busca já ignora os "deletados".
     */
    public function index()
    {
        $ativos = AtivoTI::with(['responsavel', 'setor'])->orderBy('id', 'desc')->paginate(10);
        return view('ativos.index', compact('ativos'));
    }

    /**
     * Mostra o formulário para criar um novo ativo.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $setores = Setor::orderBy('nome')->get();
        return view('ativos.create', compact('users', 'setores'));
    }

    /**
     * Salva o novo ativo. A validação foi limpa.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_ativo' => 'required|string|max:150',
            'numero_serie' => 'required|string|max:100|unique:ativos_ti,numero_serie',
            'tipo_ativo' => 'required|string|max:50',
            'status_condicao' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id',
            'setor_id' => 'required|exists:setores,id',
        ]);

        AtivoTI::create($validatedData);
        return redirect()->route('ativos.index')->with('success', 'Ativo cadastrado com sucesso!');
    }

    /**
     * Exibe os detalhes de um ativo específico e seu histórico de problemas.
     */
    public function show(AtivoTI $ativo)
    {
        // Carrega o relacionamento com os problemas para exibir na view
        $ativo->load(['responsavel', 'setor', 'problemas.autor']);
        return view('ativos.show', compact('ativo'));
    }

    /**
     * Mostra o formulário para editar um ativo.
     */
    public function edit(AtivoTI $ativo)
    {
        $users = User::orderBy('name')->get();
        $setores = Setor::orderBy('nome')->get();
        return view('ativos.edit', compact('ativo', 'users', 'setores'));
    }

    /**
     * Atualiza um ativo existente. A validação foi limpa.
     */
    public function update(Request $request, AtivoTI $ativo)
    {
        $validatedData = $request->validate([
            'nome_ativo' => 'required|string|max:150',
            'numero_serie' => ['required', 'string', 'max:100', Rule::unique('ativos_ti')->ignore($ativo->id)],
            'tipo_ativo' => 'required|string|max:50',
            'status_condicao' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id',
            'setor_id' => 'required|exists:setores,id',
        ]);

        $ativo->update($validatedData);
        return redirect()->route('ativos.index')->with('success', 'Ativo atualizado com sucesso!');
    }

    /**
     * Move o ativo para a lixeira usando Soft Deletes.
     */
    public function destroy(AtivoTI $ativo)
    {
        // O Laravel agora cuida de tudo com este simples comando
        $ativo->delete();
        return redirect()->route('ativos.index')->with('success', 'Ativo movido para a lixeira!');
    }

    /**
     * Exibe os ativos que estão na lixeira.
     */
    public function trash()
    {
        // O método onlyTrashed() só é possível por causa do Trait SoftDeletes
        $ativos = AtivoTI::onlyTrashed()->with(['responsavel', 'setor'])->orderBy('id', 'desc')->paginate(10);
        return view('ativos.trash', compact('ativos'));
    }

    /**
     * Restaura um ativo da lixeira.
     */
    public function restore(AtivoTI $ativo)
    {
        // O método restore() também vem do Trait SoftDeletes
        $ativo->restore();
        return redirect()->route('ativos.trash')->with('success', 'Ativo restaurado com sucesso!');
    }
}