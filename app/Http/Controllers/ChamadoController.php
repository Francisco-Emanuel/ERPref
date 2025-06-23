<?php

namespace App\Http\Controllers;

use App\Models\AtivoTI;
use App\Models\AtualizacaoChamado;
use App\Models\Chamado;
use App\Models\Problema;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChamadoController extends Controller
{
    /**
     * Exibe a lista de todos os chamados.
     */
    public function index()
    {
        $this->authorize('view-chamados');

        $chamados = Chamado::with(['problema.ativo', 'solicitante', 'tecnico', 'categoria'])
                            ->latest()
                            ->paginate(15);

        return view('chamados.index', compact('chamados'));
    }

    /**
     * Mostra o formulário para criar um novo chamado.
     * (MÉTODO CORRIGIDO)
     */
    public function create()
    {
        // VERIFICA: O usuário logado tem a permissão 'create-chamados'?
        $this->authorize('create-chamados');

        // Busca os dados necessários para preencher os menus de seleção do formulário
        $ativos = AtivoTI::orderBy('nome_ativo')->get();
        $categorias = Categoria::orderBy('nome_amigavel')->get();
        // Apenas usuários que não são 'clientes' podem ser técnicos
        $tecnicos = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Cliente');
        })->orderBy('name')->get();

        return view('chamados.create', compact('ativos', 'categorias', 'tecnicos'));
    }

    /**
     * Salva o novo chamado E o novo problema no banco de dados.
     */
    public function store(Request $request)
    {
        $this->authorize('create-chamados');

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao_problema' => 'required|string',
            'ativo_id' => 'nullable|exists:ativos_ti,id',
            'prioridade' => 'required|string|max:50',
            'categoria_id' => 'nullable|exists:categorias,id',
            'tecnico_id' => 'nullable|exists:users,id',
        ]);
        
        $problema = Problema::create([
            'descricao' => $validatedData['descricao_problema'],
            'ativo_ti_id' => $validatedData['ativo_id'],
            'autor_id' => Auth::id(),
        ]);

        Chamado::create([
            'titulo' => $validatedData['titulo'],
            'descricao_inicial' => $validatedData['descricao_problema'],
            'problema_id' => $problema->id,
            'solicitante_id' => Auth::id(),
            'status' => 'Aberto',
            'prioridade' => $validatedData['prioridade'],
            'categoria_id' => $validatedData['categoria_id'],
            'tecnico_id' => $validatedData['tecnico_id'],
            'ativo_id' => $validatedData['ativo_id'],
        ]);

        return redirect()->route('chamados.index')->with('success', 'Chamado aberto com sucesso!');
    }

   /**
    * Exibe os detalhes de um chamado específico.
    */
    public function show(Chamado $chamado)
    {
        $this->authorize('view-chamados');

        $chamado->load(['problema.ativo', 'solicitante', 'tecnico', 'categoria', 'atualizacoes.autor']);
        
        return view('chamados.show', compact('chamado'));
    }
    
   /**
    * Adiciona uma nova atualização a um chamado existente.
    */
    public function addUpdate(Request $request, Chamado $chamado)
    {
        $this->authorize('view-chamados');
        
        $request->validate(['texto' => 'required|string']);

        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => $request->texto,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', 'Sua atualização foi adicionada!');
    }
}