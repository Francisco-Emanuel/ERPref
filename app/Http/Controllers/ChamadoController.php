<?php

namespace App\Http\Controllers;

use App\Enums\ChamadoStatus;
use App\Models\AtivoTI;
use App\Models\AtualizacaoChamado;
use App\Models\Chamado;
use App\Models\Departamento;
use App\Models\Problema;
use App\Models\Categoria;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Services\ChamadoService;
use App\Http\Requests\StoreChamadoRequest;

class ChamadoController extends Controller
{

    public function __construct(protected ChamadoService $chamadoService)
    {
    }
    /**
     * Exibe a lista de todos os chamados.
     */
    public function index()
    {
        $this->authorize('view-chamados');

        $chamados = Chamado::with(['problema.ativo', 'solicitante', 'tecnico', 'categoria'])
            ->filtroPrincipal() 
            ->paginate(15);

        $tecnicosDisponiveis = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Técnico de TI', 'Supervisor', 'Admin', 'Estagiário']);
        })->orderBy('name')->get();

        return view('chamados.index', compact('chamados', 'tecnicosDisponiveis'));
    }

    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create-chamados');

        $ativos = AtivoTI::orderBy('nome_ativo')->get();
        $categorias = Categoria::orderBy('nome_amigavel')->get();
        $departamentos = Departamento::orderBy('nome')->get();
        $tecnicos = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Cliente');
        })->orderBy('name')->get();
        $solicitantes = User::orderBy('name')->get();

        return view('chamados.create', compact('ativos', 'categorias', 'tecnicos', 'solicitantes', 'departamentos'));
    }

    /**
     * Salva o novo chamado E o novo problema no banco de dados.
     */
    public function store(StoreChamadoRequest $request)
    {
        $validatedData = $request->validated();

        $this->chamadoService->criarNovoChamado($validatedData);

        return redirect()->route('chamados.index')->with('success', 'Chamado aberto com sucesso!');
    }

    /**
     * Inicia ou reinicia o SLA para um chamado.
     * @param \App\Models\Chamado $chamado
     * @return void
     */
    private function startOrResetSla(Chamado $chamado): void
    {
        $now = Carbon::now();
        $chamado->data_inicio_sla = $now;

        $prazoSla = match ($chamado->prioridade) {
            'Urgente' => (clone $now)->addWeekdays(1),
            'Alta' => (clone $now)->addWeekdays(3),
            'Média' => (clone $now)->addWeekdays(5),
            default => (clone $now)->addWeekdays(10),
        };

        $chamado->prazo_sla = $prazoSla;
        $chamado->save();
    }

    /**
     * Exibe os detalhes de um chamado específico.
     */
    public function show(Chamado $chamado)
    {
        $this->authorize('view-chamados');

        $chamado->load(['problema.ativo', 'solicitante', 'tecnico', 'categoria']);

        $chatMessages = $chamado->atualizacoes()->where('is_system_log', false)->get();

        $historyLogs = $chamado->atualizacoes()->where('is_system_log', true)->get();

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
            'texto' => 'OBS: ' . $request->texto,
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', 'Sua atualização foi adicionada!');
    }
    /**
     * Atualiza o status de um chamado específico.
     */
    public function updateStatus(Request $request, Chamado $chamado)
    {
        $this->authorize('edit-chamados');

        $validated = $request->validate([
            'status' => ['required', Rule::enum(ChamadoStatus::class)],
        ]);

        $newStatus = ChamadoStatus::from($validated['status']);

        $oldStatus = $chamado->status->value;

        $chamado->status = $newStatus;

        if ($newStatus === ChamadoStatus::RESOLVIDO && is_null($chamado->data_resolucao)) {
            $chamado->data_resolucao = now();
        }
        if ($newStatus === ChamadoStatus::FECHADO) {
            $chamado->data_fechamento = now();
            if (is_null($chamado->data_resolucao)) {
                $chamado->data_resolucao = now();
            }
        }

        $chamado->save();

        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => "Status do chamado alterado de '{$oldStatus}' para '{$newStatus->value}'.",
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', 'Status do chamado atualizado com sucesso!');
    }
    /**
     * Atribui o chamado ao técnico logado.
     */
    public function assignToSelf(Chamado $chamado)
    {
        $this->authorize('edit-chamados');

        if ($chamado->tecnico_id) {
            return back()->with('error', 'Este chamado já foi atribuído a outro técnico.');
        }

        $chamado->tecnico_id = Auth::id();
        //$this->startOrResetSla($chamado);
        $chamado->save();

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

        $meusChamados = Chamado::with(['problema.ativo', 'solicitante'])
            ->where('tecnico_id', Auth::id()) 
            ->filtroPrincipal() 
            ->paginate(15);

        return view('chamados.my-chamados', ['chamados' => $meusChamados]);
    }
    /**
     * Summary of attend
     * @param \App\Models\Chamado $chamado
     * @return \Illuminate\Http\RedirectResponse
     */
    public function attend(Chamado $chamado)
    {
        // Verifica se o usuário logado é o técnico atribuído
        if ($chamado->tecnico_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para atender este chamado.');
        }

        // Verifica se o chamado já não está em atendimento, resolvido ou fechado
        if (in_array($chamado->status, [ChamadoStatus::EM_ANDAMENTO, ChamadoStatus::RESOLVIDO, ChamadoStatus::FECHADO])) {
            return back()->with('error', 'Este chamado já está em atendimento ou foi finalizado.');
        }

        $chamado->status = ChamadoStatus::EM_ANDAMENTO;
        $this->startOrResetSla($chamado); // Inicia o SLA aqui!
        // O save() já é feito dentro de startOrResetSla()

        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => "Chamado em atendimento por " . Auth::user()->name . ". O SLA foi iniciado.",
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', 'Chamado em atendimento!');
    }
    /**
     * Summary of resolve (Feito por IA)
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chamado $chamado
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resolve(Request $request, Chamado $chamado)
    {
        // 1. Autoriza a ação de fechar chamados (permissão 'close-chamados')
        $this->authorize('close-chamados');

        $user = Auth::user(); // Obtém o usuário autenticado

        // 2. Lógica para atribuir o chamado ao administrador se ele estiver não atribuído
        // Esta verificação deve vir ANTES da verificação de permissão do técnico.
        if (!$chamado->tecnico_id && $user->hasRole('Admin')) {
            $chamado->tecnico_id = $user->id;
            // Opcional: Adiciona um log de sistema para esta auto-atribuição
            AtualizacaoChamado::create([
                'chamado_id' => $chamado->id,
                'autor_id' => $user->id,
                'texto' => "Chamado automaticamente atribuído a " . $user->name . " (Admin) ao ser resolvido.",
                'is_system_log' => true,
            ]);
        }

        // 3. Verificação de permissão mais flexível:
        // Permite que o técnico atribuído resolva o chamado, OU
        // permite que um Administrador ou Supervisor resolva QUALQUER chamado (atribuído ou não).
        // Se o usuário não for o técnico atribuído E não for Admin/Supervisor, então ele não tem permissão.
        if ($chamado->tecnico_id !== $user->id && !$user->hasAnyRole(['Admin', 'Supervisor'])) {
            abort(403, 'Você não tem permissão para resolver este chamado. Apenas o técnico responsável, um Administrador ou Supervisor pode fazê-lo.');
        }

        // 4. Validação dos dados do formulário
        $validated = $request->validate([
            'solucao_final' => 'required|string|min:10',
            'servico_executado' => 'accepted', 
        ]);

        // 5. Atualiza os campos do chamado
        $chamado->solucao_final = $validated['solucao_final'];
        $chamado->status = \App\Enums\ChamadoStatus::RESOLVIDO;
        $chamado->data_resolucao = now();
        $chamado->save(); // Salva as alterações, incluindo o tecnico_id se foi atualizado

        // 6. Cria o log de resolução do chamado
        $logTexto = "Chamado marcado como Resolvido por " . $user->name . ".\n\n";
        $logTexto .= "Solução registrada: " . $validated['solucao_final'];

        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => $user->id,
            'texto' => $logTexto,
            'is_system_log' => true,
        ]);

        // 7. Redireciona com mensagem de sucesso
        return redirect()->route('chamados.show', $chamado)->with('success', 'Chamado resolvido com sucesso!');
    }
    /**
     * Summary of escalate
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chamado $chamado
     * @return \Illuminate\Http\RedirectResponse
     */
    public function escalate(Request $request, Chamado $chamado)
    {
        $this->authorize('edit-chamados');
        if ($chamado->tecnico_id !== Auth::id()) {
            abort(403, 'Apenas o técnico responsável pode escalar este chamado.');
        }

        $validated = $request->validate([
            'new_tecnico_id' => 'required|exists:users,id',
        ]);

        $oldTechnicianName = $chamado->tecnico->name;
        $newTechnician = User::find($validated['new_tecnico_id']);

        $chamado->tecnico_id = $newTechnician->id;
        $chamado->save();

        $logTexto = "Chamado escalado de {$oldTechnicianName} para {$newTechnician->name} por " . Auth::user()->name . ".";
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => $logTexto,
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', "Chamado escalado para {$newTechnician->name}!");
    }
    /**
     * Summary of atribuir
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chamado $chamado
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atribuir(Request $request, Chamado $chamado)
    {
        $this->authorize('edit-chamados');

        $validated = $request->validate([
            'new_tecnico_id' => 'required|exists:users,id',
        ]);

        $newTechnician = User::find($validated['new_tecnico_id']);
        $logTexto = '';

        if ($chamado->tecnico) {
            $oldTechnicianName = $chamado->tecnico->name;
            $logTexto = "Chamado escalado de {$oldTechnicianName} para {$newTechnician->name} por " . Auth::user()->name . ".";
        } else {
            $logTexto = "Chamado atribuído a {$newTechnician->name} por " . Auth::user()->name . ".";
        }

        $chamado->tecnico_id = $newTechnician->id;

        $this->startOrResetSla($chamado); // Este save() já está dentro do método

        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => $logTexto,
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.index')->with('success', "Chamado atribuído a {$newTechnician->name}!");
    }
    /**
     * Summary of close
     * @param \App\Models\Chamado $chamado
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close(Chamado $chamado)
    {
        $user = Auth::user();

        if (!$user->hasRole("Admin") && $user->id !== $chamado->solicitante_id) {
            abort(403, 'Você não tem permissão para fechar este chamado.');
        }

        if ($chamado->status !== \App\Enums\ChamadoStatus::RESOLVIDO) {
            return back()->with('error', 'Este chamado não pode ser fechado, pois não está com o status "Resolvido".');
        }

        $chamado->status = \App\Enums\ChamadoStatus::FECHADO;
        $chamado->data_fechamento = now();
        $chamado->save();

        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => $user->id,
            'texto' => 'Chamado fechado pelo solicitante.',
            'is_system_log' => true,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', 'Chamado fechado com sucesso!');
    }
    /**
     * Summary of reopen
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chamado $chamado
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reopen(Request $request, Chamado $chamado)
    {
        if (Auth::id() !== $chamado->solicitante_id) {
            abort(403, 'Você não tem permissão para reabrir este chamado.');
        }

        if ($chamado->status !== \App\Enums\ChamadoStatus::FECHADO) {
            return back()->with('error', 'Apenas chamados que já foram fechados podem ser reabertos.');
        }

        $validated = $request->validate([
            'motivo_reabertura' => 'required|string|min:15',
        ]);

        $chamado->status = \App\Enums\ChamadoStatus::ABERTO;
        $chamado->tecnico_id = null; 
        $chamado->solucao_final = null;
        $chamado->data_resolucao = null;
        $chamado->data_fechamento = null;
        $chamado->save();

        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => "Motivo da Reabertura: " . $validated['motivo_reabertura'],
            'is_system_log' => true,
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

        $chamado->load(['problema.ativo', 'solicitante', 'tecnico', 'categoria', 'atualizacoes.autor', 'departamento']);

        //$chatMessages = $chamado->atualizacoes()->where('is_system_log', false)->get();
        $historyLogs = $chamado->atualizacoes()->where('is_system_log', true)->get();

        $pdf = Pdf::loadView('chamados.report', [
            'chamado' => $chamado,
            //'chatMessages' => $chatMessages,
            'historyLogs' => $historyLogs
        ]);

        return $pdf->download("relatorio-chamado-{$chamado->id}.pdf");
    }
    public function getUserDetails(User $user)
    {
        $this->authorize('create-chamados');

        $user->load('departamento');

        return response()->json([
            'departamento_nome' => $user->departamento->nome ?? 'Não definido',
            'departamento_local' => $user->departamento->local ?? '',
        ]);
    }

}