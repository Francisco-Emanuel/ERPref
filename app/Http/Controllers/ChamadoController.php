<?php

namespace App\Http\Controllers;

use App\Enums\ChamadoStatus;
use App\Models\AtivoTI;
use App\Models\AtualizacaoChamado;
use App\Models\Chamado;
use App\Models\Problema;
use App\Models\Categoria;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ChamadoController extends Controller
{
    /**
     * Exibe a lista de todos os chamados.
     */
    public function index()
    {
        $this->authorize('view-chamados');

        // A query agora é muito mais limpa!
        $chamados = Chamado::with(['problema.ativo', 'solicitante', 'tecnico', 'categoria'])
            ->filtroPrincipal() // <-- APLICA TODA A LÓGICA
            ->paginate(15);

        $tecnicosDisponiveis = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Técnico de TI', 'Supervisor', 'Admin', 'Estagiário']);
        })->orderBy('name')->get();

        return view('chamados.index', compact('chamados', 'tecnicosDisponiveis'));
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
            'local' => 'required|string|max:255',
            'ativo_id' => 'nullable|exists:ativos_ti,id',
            'prioridade' => 'required|string|max:50',
            'categoria_id' => 'nullable|exists:categorias,id',
            'tecnico_id' => 'nullable|exists:users,id',
        ]);

        $dataAbertura = Carbon::now();
        $prazoSla = match ($validatedData['prioridade']) {
            'Urgente' => (clone $dataAbertura)->addWeekdays(1), // 1 dia útil
            'Alta' => (clone $dataAbertura)->addWeekdays(3),    // 3 dias úteis
            'Média' => (clone $dataAbertura)->addWeekdays(5),   // 5 dias úteis
            default => (clone $dataAbertura)->addWeekdays(10),  // Padrão de 10 dias para 'Baixa'
        };

        $problema = Problema::create([
            'descricao' => $validatedData['descricao_problema'],
            'ativo_ti_id' => $validatedData['ativo_id'],
            'autor_id' => Auth::id(),
        ]);

        $chamado = Chamado::create([
            'titulo' => $validatedData['titulo'],
            'descricao_inicial' => $validatedData['descricao_problema'],
            'problema_id' => $problema->id,
            'local' => $validatedData['local'],
            'solicitante_id' => Auth::id(),
            'status' => ChamadoStatus::ABERTO,
            'prioridade' => $validatedData['prioridade'],
            'categoria_id' => $validatedData['categoria_id'],
            'prazo_sla' => $prazoSla,
            //'tecnico_id' => $validatedData['tecnico_id'],
            'ativo_id' => $validatedData['ativo_id'],
        ]);

        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id, // Assumindo que o resultado do create está em $chamado
            'autor_id' => Auth::id(),
            'texto' => 'Chamado aberto.',
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.index')->with('success', 'Chamado aberto com sucesso!');
    }

    /**
     * Exibe os detalhes de um chamado específico.
     */
    public function show(Chamado $chamado)
    {
        $this->authorize('view-chamados');

        // Carrega as relações principais do chamado
        $chamado->load(['problema.ativo', 'solicitante', 'tecnico', 'categoria']);

        // Busca o chat (mensagens de usuários)
        $chatMessages = $chamado->atualizacoes()->where('is_system_log', false)->get();

        // Busca o histórico (logs de sistema)
        $historyLogs = $chamado->atualizacoes()->where('is_system_log', true)->get();

        // Busca os técnicos disponíveis para escalação
        $tecnicosDisponiveis = User::whereHas('roles', fn($q) => $q->whereIn('name', ['Técnico de TI', 'Supervisor', 'Admin']))
            ->when($chamado->tecnico_id, fn($q) => $q->where('id', '!=', $chamado->tecnico_id))
            ->orderBy('name')->get();

        return view('chamados.show', compact('chamado', 'chatMessages', 'historyLogs', 'tecnicosDisponiveis'));
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
    /**
     * Atualiza o status de um chamado específico.
     */
    public function updateStatus(Request $request, Chamado $chamado)
    {
        // 1. Autorização: Apenas usuários com permissão podem editar.
        $this->authorize('edit-chamados');

        // 2. Validação: Garante que o status enviado é um valor válido do nosso Enum.
        $validated = $request->validate([
            'status' => ['required', Rule::enum(ChamadoStatus::class)],
        ]);

        // Pega o novo status a partir do valor validado.
        $newStatus = ChamadoStatus::from($validated['status']);

        // 3. Lógica de Negócio:
        // Salva o status antigo para usar na mensagem de log.
        $oldStatus = $chamado->status->value;

        // Atualiza o status do chamado.
        $chamado->status = $newStatus;

        // Se o chamado for Resolvido ou Fechado, atualiza as datas correspondentes.
        if ($newStatus === ChamadoStatus::RESOLVIDO && is_null($chamado->data_resolucao)) {
            $chamado->data_resolucao = now();
        }
        if ($newStatus === ChamadoStatus::FECHADO) {
            $chamado->data_fechamento = now();
            // Se foi fechado direto, também preenche a data de resolução.
            if (is_null($chamado->data_resolucao)) {
                $chamado->data_resolucao = now();
            }
        }

        // 4. Persistência:
        $chamado->save();

        // Cria uma atualização automática para registrar a mudança de status no histórico.
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => "Status do chamado alterado de '{$oldStatus}' para '{$newStatus->value}'.",
            'is_system_log' => true,
        ]);

        // 5. Redirecionamento:
        return redirect()->route('chamados.show', $chamado)->with('success', 'Status do chamado atualizado com sucesso!');
    }
    /**
     * Atribui o chamado ao técnico logado.
     */
    public function assignToSelf(Chamado $chamado)
    {
        // Apenas usuários com permissão de editar chamados podem se atribuir
        $this->authorize('edit-chamados');

        // Garante que o chamado não seja atribuído a outra pessoa no meio tempo
        if ($chamado->tecnico_id) {
            return back()->with('error', 'Este chamado já foi atribuído a outro técnico.');
        }

        // Atribui o chamado ao usuário logado
        $chamado->tecnico_id = Auth::id();
        $chamado->save();

        // Cria uma atualização automática para o histórico
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => "Chamado atribuído a " . Auth::user()->name . ".",
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', "Chamado atribuído a você! Agora você pode iniciar o atendimento.");
    }
    /**
     * Exibe a lista de chamados atribuídos ao usuário logado.
     */
    public function myChamados()
    {
        $this->authorize('view-chamados');

        // Adicionamos nosso filtro à query que já existia
        $meusChamados = Chamado::with(['problema.ativo', 'solicitante'])
            ->where('tecnico_id', Auth::id()) // Primeiro filtra por técnico
            ->filtroPrincipal() // Depois aplica a lógica de status e ordenação
            ->paginate(15);

        return view('chamados.my-chamados', ['chamados' => $meusChamados]);
    }
    public function attend(Chamado $chamado)
    {
        // Garante que apenas o técnico atribuído possa atender o chamado
        if ($chamado->tecnico_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para atender este chamado.');
        }

        $chamado->status = \App\Enums\ChamadoStatus::EM_ANDAMENTO;
        $chamado->save();

        // Cria uma atualização automática para o histórico
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => "Chamado em atendimento por " . Auth::user()->name . ".",
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', 'Chamado em atendimento!');
    }
    public function resolve(Request $request, Chamado $chamado)
    {
        // Garante que apenas o técnico atribuído possa resolver o chamado
        $this->authorize('close-chamados');
        if ($chamado->tecnico_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para resolver este chamado.');
        }

        // Valida os dados enviados pelo modal
        $validated = $request->validate([
            'solucao_final' => 'required|string|min:10',
            'servico_executado' => 'accepted', // O 'accepted' garante que a checkbox foi marcada
        ]);

        // Atualiza o chamado com as informações da resolução
        $chamado->solucao_final = $validated['solucao_final'];
        $chamado->status = \App\Enums\ChamadoStatus::RESOLVIDO;
        $chamado->data_resolucao = now();
        $chamado->save();

        $logTexto = "Chamado marcado como Resolvido por " . Auth::user()->name . ".\n\n";
        $logTexto .= "Solução registrada: " . $validated['solucao_final'];

        // Cria uma atualização automática para o histórico
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => $logTexto,
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', 'Chamado resolvido com sucesso!');
    }
    /**
     * Escala/Reatribui um chamado para outro técnico.
     */
    public function escalate(Request $request, Chamado $chamado)
    {
        // Garante que apenas o técnico atual pode escalar o chamado
        $this->authorize('edit-chamados');
        if ($chamado->tecnico_id !== Auth::id()) {
            abort(403, 'Apenas o técnico responsável pode escalar este chamado.');
        }

        // Valida se um novo técnico foi selecionado
        $validated = $request->validate([
            'new_tecnico_id' => 'required|exists:users,id',
        ]);

        $oldTechnicianName = $chamado->tecnico->name;
        $newTechnician = User::find($validated['new_tecnico_id']);

        // Atualiza o chamado com o ID do novo técnico
        $chamado->tecnico_id = $newTechnician->id;
        $chamado->save();

        // Cria a entrada no histórico
        $logTexto = "Chamado escalado de {$oldTechnicianName} para {$newTechnician->name} por " . Auth::user()->name . ".";
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => $logTexto,
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', "Chamado escalado para {$newTechnician->name}!");
    }
    public function atribuir(Request $request, Chamado $chamado)
    {
        // Garante que apenas o técnico atual pode escalar o chamado
        $this->authorize('edit-chamados');
        $user = Auth::user();
        if (!$user->hasrole('Admin')) {
            abort(403, 'Apenas administradores podem atribuir chamados.');
        }

        // Valida se um novo técnico foi selecionado
        $validated = $request->validate([
            'new_tecnico_id' => 'required|exists:users,id',
        ]);

        $newTechnician = User::find($validated['new_tecnico_id']);
        $logTexto = '';

        // Verifica se o chamado JÁ TINHA um técnico.
        if ($chamado->tecnico) {
            // Se sim, é uma ESCALAÇÃO. Registra o nome do técnico antigo.
            $oldTechnicianName = $chamado->tecnico->name;
            $logTexto = "Chamado escalado de {$oldTechnicianName} para {$newTechnician->name} por " . Auth::user()->name . ".";
        } else {
            // Se não, é uma ATRIBUIÇÃO inicial.
            $logTexto = "Chamado atribuído a {$newTechnician->name} por " . Auth::user()->name . ".";
        }

        // Atualiza o chamado com o ID do novo técnico
        $chamado->tecnico_id = $newTechnician->id;
        $chamado->save();

        // Cria a entrada no histórico
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => $logTexto,
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', "Chamado escalado para {$newTechnician->name}!");
    }
    /**
     * Fecha um chamado que já foi resolvido. Ação do solicitante.
     */
    public function close(Chamado $chamado)
    {
        // Garante que apenas o solicitante pode fechar o chamado
        if (Auth::id() !== $chamado->solicitante_id) {
            abort(403, 'Apenas o solicitante pode fechar este chamado.');
        }
        // Garante que o chamado esteja resolvido para ser fechado
        if ($chamado->status !== \App\Enums\ChamadoStatus::RESOLVIDO) {
            return back()->with('error', 'Apenas chamados resolvidos podem ser fechados.');
        }

        $chamado->status = \App\Enums\ChamadoStatus::FECHADO;
        $chamado->data_fechamento = now();
        $chamado->save();

        // Cria uma atualização automática para o histórico
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => 'Chamado fechado pelo solicitante.',
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', 'Chamado fechado com sucesso!');
    }
    /**
     * Reabre um chamado que estava fechado. Ação do solicitante.
     */
    public function reopen(Request $request, Chamado $chamado)
    {
        // Garante que apenas o solicitante pode reabrir o chamado
        if (Auth::id() !== $chamado->solicitante_id) {
            abort(403, 'Apenas o solicitante pode reabrir este chamado.');
        }
        if ($chamado->status !== \App\Enums\ChamadoStatus::FECHADO) {
            return back()->with('error', 'Apenas chamados fechados podem ser reabertos.');
        }

        // Valida o motivo da reabertura
        $validated = $request->validate([
            'motivo_reabertura' => 'required|string|min:15',
        ]);

        // Reseta o estado do chamado
        $chamado->status = \App\Enums\ChamadoStatus::ABERTO;
        $chamado->tecnico_id = null; // Volta para a fila geral de técnicos
        $chamado->solucao_final = null;
        $chamado->data_resolucao = null;
        $chamado->data_fechamento = null;
        $chamado->save();

        // Adiciona o motivo da reabertura no "chat"
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => "Motivo da Reabertura: " . $validated['motivo_reabertura'],
            'is_system_log' => true,
        ]);

        // Adiciona um log no histórico
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => "Chamado reaberto pelo solicitante.",
            'is_system_log' => true, // Log de sistema
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', 'Chamado reaberto e enviado para a fila de atendimento!');
    }
    /**
     * Exibe a lista de chamados fechados.
     */
    public function closedIndex()
    {
        $this->authorize('view-chamados');

        $chamadosFechados = Chamado::with(['problema.ativo', 'solicitante', 'tecnico'])
            ->where('status', \App\Enums\ChamadoStatus::FECHADO)
            ->latest('data_fechamento') // Ordena pelos mais recentemente fechados
            ->paginate(15);

        return view('chamados.closed', ['chamados' => $chamadosFechados]);
    }
    public function generateReport(Chamado $chamado)
    {
        $this->authorize('view-chamados');

        // Carrega todas as informações necessárias
        $chamado->load(['problema.ativo', 'solicitante', 'tecnico', 'categoria', 'atualizacoes.autor']);

        // Separa as atualizações entre chat e histórico
        //$chatMessages = $chamado->atualizacoes()->where('is_system_log', false)->get();
        $historyLogs = $chamado->atualizacoes()->where('is_system_log', true)->get();

        // Passa os dados para a nova view de relatório
        $pdf = Pdf::loadView('chamados.report', [
            'chamado' => $chamado,
            //'chatMessages' => $chatMessages,
            'historyLogs' => $historyLogs
        ]);

        // Define o nome do arquivo e força o download
        return $pdf->download("relatorio-chamado-{$chamado->id}.pdf");
    }

}