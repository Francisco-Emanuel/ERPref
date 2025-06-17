<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SetorController extends Controller
{
    
    /**
     * Exibe a lista de todos os setores.
     */
    public function index()
    {
        // 'withCount' é um método eficiente para contar registros em relacionamentos
        $setores = Setor::withCount(['users', 'ativos'])
                        ->orderBy('name')
                        ->paginate(10);
                        
        return view('setores.index', compact('setores'));
    }

    /**
     * Mostra o formulário para criar um novo setor.
     */
    public function create()
    {
        return view('setores.create');
    }

    /**
     * Salva o novo setor no banco de dados.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:setores,name',
        ]);

        Setor::create($validatedData);

        return redirect()->route('setores.index')->with('success', 'Setor criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um setor.
     */
    public function edit(Setor $setor)
    {
        return view('setores.edit', compact('setor'));
    }

    /**
     * Atualiza o setor no banco de dados.
     */
    public function update(Request $request, Setor $setor)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('setores')->ignore($setor->id)],
        ]);

        $setor->update($validatedData);

        return redirect()->route('setores.index')->with('success', 'Setor atualizado com sucesso!');
    }

    /**
     * Remove um setor do banco de dados, com trava de segurança.
     */
    public function destroy(Setor $setor)
    {
        // TRAVA DE SEGURANÇA: Verifica se há usuários ou ativos ligados a este setor
        if ($setor->users()->count() > 0 || $setor->ativos()->count() > 0) {
            return redirect()->route('setores.index')
                             ->with('error', 'Não é possível excluir este setor, pois ele está associado a usuários ou ativos.');
        }

        $setor->delete();

        return redirect()->route('setores.index')->with('success', 'Setor excluído com sucesso!');
    }
}