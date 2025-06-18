<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use App\Models\Problema;
use App\Models\Categoria;
use App\Models\User;
use App\Models\AtivoTI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AtualizacaoChamado;

class ChamadoController extends Controller
{
    /**
     * Exibe a lista de todos os chamados.
     */
    public function index()
    {
        // Carrega os chamados com seus relacionamentos para evitar múltiplas queries
        $chamados = Chamado::with(['problema.ativo', 'solicitante', 'tecnico'/*, 'categoria'*/])
            ->latest()
            ->paginate(15);

        return view('chamados.index', compact('chamados'));
    }

    /**
     * Mostra o formulário para o usuário criar um novo chamado.
     * Agora, em vez de receber um problema, ele busca a lista de ativos.
     */
    public function create()
    {
        // Busca dados para os dropdowns do formulário
        $ativos = AtivoTI::orderBy('nome_ativo')->get(); // O usuário poderá escolher o ativo
        $categorias = Categoria::orderBy('nome_amigavel')->get();
        $tecnicos = User::where('nivel_hierarquico', '!=', 'Cliente')->orderBy('name')->get();

        return view('chamados.create', compact('ativos', 'categorias', 'tecnicos'));
    }

    /**
     * Salva o novo chamado E o novo problema no banco de dados.
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados do formulário
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao_problema' => 'required|string', // Agora validamos a descrição do problema
            'ativo_ti_id' => 'required|exists:ativos_ti,id', // E o ID do ativo
            'prioridade' => 'required|string|max:50',
            'categoria_id' => 'required|exists:categorias,id',
            'tecnico_id' => 'nullable|exists:users,id',
        ]);

        // 2. Cria primeiro o registro do Problema
        $problema = Problema::create([
            'descricao' => $validatedData['descricao_problema'],
            'ativo_ti_id' => $validatedData['ativo_ti_id'],
            'autor_id' => Auth::id(), // O autor do problema é o usuário logado
        ]);

        // 3. Cria o Chamado, ligando-o ao problema recém-criado
        $chamado = Chamado::create([
            'titulo' => $validatedData['titulo'],
            'problema_id' => $problema->id, // Usa o ID do problema que acabamos de criar
            'solicitante_id' => Auth::id(), // O solicitante também é o usuário logado
            'status' => 'Aberto',
            'prioridade' => $validatedData['prioridade'],
            'categoria_id' => $validatedData['categoria_id'],
            'tecnico_id' => $validatedData['tecnico_id'],
            'ativo_id' => $validatedData['ativo_ti_id'], // Preenchemos o campo de atalho
        ]);

        return redirect()->route('chamados.index')->with('success', 'Chamado aberto com sucesso!');
    }

    public function addUpdate(Request $request, Chamado $chamado)
    {
        // 1. Valida se o campo de texto não está vazio
        $request->validate([
            'texto' => 'required|string',
        ]);

        // 2. Cria a nova atualização no banco de dados
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(), // Pega o ID do usuário logado
            'texto' => $request->texto,
        ]);

        // 3. Redireciona de volta para a página do chamado com uma mensagem de sucesso
        return redirect()->route('chamados.show', $chamado)->with('success', 'Sua atualização foi adicionada!');
    }

    /**
     * Exibe os detalhes de um chamado específico (o histórico completo).
     */
    public function show(Chamado $chamado)
    {
        // Carrega todos os relacionamentos necessários para a view
        $chamado->load(['problema.ativo', 'solicitante', 'tecnico', 'categoria', 'atualizacoes.autor']);

        return view('chamados.show', compact('chamado'));
    }
}