<?php

namespace App\Http\Controllers;

use App\Models\AtivoTI;
use App\Models\Departamento; // Changed from Setor
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AtivoTiController extends Controller
{
    /**
     * Exibe a lista de ativos não deletados.
     */
    public function index()
    {
        $this->authorize('view-ativos');
        
        // Changed 'setor' to 'departamento' in eager loading
        $ativos = AtivoTI::with(['responsavel', 'departamento'])->orderBy('id', 'desc')->paginate(10);
        return view('ativos.index', compact('ativos'));
    }

    /**
     * Mostra o formulário para criar um novo ativo.
     */
    public function create()
    {
        $this->authorize('create-ativos');

        $users = User::orderBy('name')->get();
        // Changed 'Setor' to 'Departamento' and '$setores' to '$departamentos'
        $departamentos = Departamento::orderBy('nome')->get();
        return view('ativos.create', compact('users', 'departamentos')); // Passed 'departamentos'
    }

    /**
     * Salva o novo ativo no banco de dados.
     */
    public function store(Request $request)
    {
        $this->authorize('create-ativos');

        $validatedData = $request->validate([
            'nome_ativo' => 'required|string|max:150',
            'numero_serie' => 'required|string|max:100|unique:ativos_ti,numero_serie',
            'tipo_ativo' => 'required|string|max:50',
            'status_condicao' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id',
            'departamento_id' => 'required|exists:departamentos,id', // Changed from 'setor_id' and 'setores'
        ]);

        AtivoTI::create($validatedData);

        return redirect()->route('ativos.index')->with('success', 'Ativo cadastrado com sucesso!');
    }

    /**
     * Exibe os detalhes de um ativo específico e seu histórico de problemas.
     */
    public function show(AtivoTI $ativo)
    {
        $this->authorize('view-ativos');

        // Changed 'setor' to 'departamento' in eager loading
        $ativo->load(['responsavel', 'departamento', 'problemas.autor']);
        return view('ativos.show', compact('ativo'));
    }

    /**
     * Mostra o formulário para editar um ativo.
     */
    public function edit(AtivoTI $ativo)
    {
        $this->authorize('edit-ativos');

        $users = User::orderBy('name')->get();
        // Changed 'Setor' to 'Departamento' and '$setores' to '$departamentos'
        $departamentos = Departamento::orderBy('nome')->get();
        return view('ativos.edit', compact('ativo', 'users', 'departamentos')); // Passed 'departamentos'
    }

    /**
     * Atualiza um ativo existente.
     */
    public function update(Request $request, AtivoTI $ativo)
    {
        $this->authorize('edit-ativos');

        $validatedData = $request->validate([
            'nome_ativo' => 'required|string|max:150',
            'numero_serie' => ['required', 'string', 'max:100', Rule::unique('ativos_ti')->ignore($ativo->id)],
            'tipo_ativo' => 'required|string|max:50',
            'status_condicao' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id',
            'departamento_id' => 'required|exists:departamentos,id', // Changed from 'setor_id' and 'setores'
        ]);

        $ativo->update($validatedData);

        return redirect()->route('ativos.index')->with('success', 'Ativo atualizado com sucesso!');
    }

    /**
     * Move o ativo para a lixeira (soft delete).
     */
    public function destroy(AtivoTI $ativo)
    {
        $this->authorize('delete-ativos');

        $ativo->delete();
        return redirect()->route('ativos.index')->with('success', 'Ativo movido para a lixeira!');
    }

    /**
     * Exibe os ativos que estão na lixeira.
     */
    public function trash()
    {
        $this->authorize('delete-ativos');

        // Changed 'setor' to 'departamento' in eager loading
        $ativos = AtivoTI::onlyTrashed()->with(['responsavel', 'departamento'])->orderBy('id', 'desc')->paginate(10);
        return view('ativos.trash', compact('ativos'));
    }

    /**
     * Restaura um ativo da lixeira.
     * O Laravel automaticamente encontrará o ativo na lixeira por causa do Route Model Binding.
     */
    public function restore($id)
    {
        $this->authorize('delete-ativos');

        $ativo = AtivoTI::onlyTrashed()->findOrFail($id);
        $ativo->restore();

        return redirect()->route('ativos.trash')->with('success', 'Ativo restaurado com sucesso!');
    }
}