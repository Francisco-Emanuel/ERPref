<x-app-layout>
    {{-- Fundo principal da página --}}
    <div class="bg-slate-50">

        {{-- Cabeçalho com Título e Botão Voltar --}}
        <header class="bg-white shadow-sm no-print">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Chamado #{{ $chamado->id }}
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">{{ $chamado->titulo }}</p>
                </div>
                <div>
                    <a href="{{ route('chamados.index') }}"
                        class="inline-flex items-center gap-2 bg-white text-slate-700 font-semibold py-2 px-4 rounded-lg hover:bg-slate-100 transition-colors border border-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Voltar
                    </a>
                    @can('create-chamados')
                        <a href="{{ route('chamados.report', $chamado) }}" target="_blank"
                            class="inline-flex items-center gap-2 bg-slate-700 text-white font-semibold py-2 px-4 rounded-lg hover:bg-slate-800 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0" />
                            </svg>
                            Imprimir ordem (PDF)
                        </a>
                    @endcan
                </div>
            </div>
        </header>

        {{-- Conteúdo Principal com Layout de 2 Colunas --}}
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Coluna da Esquerda (Feed de Atividade) --}}
                <div class="lg:col-span-2 space-y-8 order-2">

                    {{-- Card da observação --}}
                    {{-- <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Observações</h3>
                        <form method="POST" action="{{ route('chamados.updates.store', $chamado) }}" class="no-print">
                            @csrf
                            <textarea name="texto" rows="3"
                                class="w-full border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Registre uma observação ou atualização..."></textarea>
                            <div class="mt-2 flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                    Registrar observação
                                </button>
                            </div>
                        </form>
                    </div> --}}

                    {{-- Card do Histórico de Eventos --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm ">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Histórico de Eventos</h3>
                        <div class="space-y-3">
                            @forelse ($historyLogs as $log)
                                <div
                                    class="text-sm flex items-start justify-between p-3 rounded-lg {{ $loop->odd ? 'bg-slate-50' : '' }}">
                                    <p class="text-slate-700 pr-4">{{ $log->texto }}</p>
                                    <p class="text-xs text-slate-500 text-right flex-shrink-0">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Nenhum evento de sistema registrado.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Coluna da Direita (Sidebar de Informações e Ações) --}}
                <div class="space-y-8">

                    {{-- Card de Informações do Chamado --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Detalhes</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($chamado->status == \App\Enums\ChamadoStatus::ABERTO) bg-green-100 text-green-800 @endif
                                        @if($chamado->status == \App\Enums\ChamadoStatus::EM_ANDAMENTO) bg-yellow-100 text-yellow-800 @endif
                                        @if($chamado->status == \App\Enums\ChamadoStatus::RESOLVIDO) bg-blue-100 text-blue-800 @endif
                                        @if($chamado->status == \App\Enums\ChamadoStatus::FECHADO) bg-slate-200 text-slate-800 @endif
                                    ">
                                        {{ $chamado->status->value }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Local do Atendimento</dt>
                                <dd class="mt-1 text-base text-slate-800">
                                    {{ $chamado->local }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Técnico responsável</dt>
                                <dd class="mt-2 text-base text-slate-700 rounded-lg">
                                    {{ $chamado->tecnico->name ?? 'Não atribuído' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Aberto para</dt>
                                <dd class="mt-2 text-base text-slate-700 rounded-lg">
                                    {{ $chamado->abertoPara ?? 'Não atribuído' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Prazo de Resolução (SLA)</dt>
                                <dd class="mt-1 text-base font-semibold">
                                    @if ($chamado->prazo_sla)
                                        @php
                                            $prazo = $chamado->prazo_sla;
                                            $statusFinalizado = in_array($chamado->status, [\App\Enums\ChamadoStatus::RESOLVIDO, \App\Enums\ChamadoStatus::FECHADO]);
                                            $texto_sla_show = '';
                                            $cor_sla_show = '';

                                            if ($statusFinalizado) {
                                                if ($chamado->data_resolucao && $chamado->data_resolucao->lte($prazo)) {
                                                    $texto_sla_show = 'Cumprido no prazo';
                                                    $cor_sla_show = 'text-green-600';
                                                } else {
                                                    $texto_sla_show = 'Finalizado com atraso';
                                                    $cor_sla_show = 'text-red-600';
                                                }
                                            } else {
                                                if ($prazo->isPast()) {
                                                    $texto_sla_show = 'Atrasado há ' . $prazo->diffForHumans(null, true);
                                                    $cor_sla_show = 'text-red-600';
                                                } else {
                                                    $texto_sla_show = 'Vence ' . $prazo->diffForHumans();
                                                    $cor_sla_show = 'text-blue-800';
                                                }
                                            }
                                        @endphp
                                        <span class="{{ $cor_sla_show }}">{{ $texto_sla_show }}</span>
                                    @else
                                        <span>Não definido</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Descrição do Problema</dt>
                                <dd class="mt-2 text-sm text-slate-700 bg-slate-50 p-4 rounded-lg break-words">
                                    {{-- A função nl2br() preserva as quebras de linha do texto original --}}
                                    {!! nl2br(e($chamado->problema->descricao)) !!}
                                </dd>
                            </div>

                        </dl>

                        {{-- Ações do Técnico --}}
                        @can('edit-chamados')
                            <div class="mt-6 border-t border-slate-300 pt-6 no-print">
                                <h4 class="text-base font-semibold text-slate-900 mb-4">Ações de Técnico</h4>
                                <div class="space-y-3">
                                    {{-- O formulário para alterar o status fica visível para todos que podem editar --}}
                                    <form method="POST" action="{{ route('chamados.updateStatus', $chamado) }}"
                                        class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" id="status"
                                            class="flex-grow border-gray-300 rounded-md shadow-sm block w-full">
                                            @foreach (App\Enums\ChamadoStatus::cases() as $status)
                                                <option value="{{ $status->value }}" @selected($chamado->status === $status)>
                                                    {{ $status->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-primary-button>Salvar</x-primary-button>
                                    </form>

                                    {{-- Botões de Resolução e Escalação --}}
                                    @if(!in_array($chamado->status, [\App\Enums\ChamadoStatus::RESOLVIDO, \App\Enums\ChamadoStatus::FECHADO]))
                                        @if($chamado->tecnico_id === Auth::id() || Auth::user()->hasAnyRole(['Admin', 'Supervisor']))
                                            <div class="flex items-center gap-4 mt-3 border-t pt-3 border-slate-300">
                                                @can('close-chamados')
                                                    <button x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'resolve-chamado-modal')"
                                                        class="flex-1 inline-flex items-center justify-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                                        Resolver
                                                    </button>
                                                @endcan

                                                <button x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'escalate-chamado-modal')"
                                                    class="flex-1 inline-flex items-center justify-center gap-2 bg-white text-slate-700 font-semibold py-2 px-4 rounded-lg hover:bg-slate-100 transition-colors border border-slate-200">
                                                    Escalar
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endcan
                    </div>

                    {{-- Ações do Solicitante: Ações que SÓ o solicitante pode fazer. --}}
                    @if(Auth::id() === $chamado->solicitante_id)
                        <div class="bg-white p-6 rounded-xl shadow-sm no-print">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4 no-print">Minhas Ações</h3>
                            @if($chamado->status === \App\Enums\ChamadoStatus::FECHADO)
                                <p class="text-sm text-slate-600 mb-4 no-print">O problema retornou? Você pode reabrir o
                                    chamado.</p>
                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'reopen-chamado-modal')"
                                    class="no-print w-full inline-flex items-center justify-center gap-2 bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 transition-colors shadow-sm">Reabrir
                                    Chamado</button>
                                    
                            @endif
                        </div>
                    @endif

                    {{-- Ação de Finalização: Aparece para o Solicitante OU Admin quando o chamado está Resolvido --}}
                    @if($chamado->status === \App\Enums\ChamadoStatus::RESOLVIDO && (Auth::id() === $chamado->solicitante_id || Auth::user()->hasAnyRole(['Admin', 'Supervisor'])))
                        <div class="bg-white p-6 rounded-xl shadow-md no-print">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Finalizar Chamado</h3>
                            <p class="text-sm text-gray-600 mb-4">O chamado foi resolvido e está pronto para ser fechado
                                permanentemente.</p>
                            <form method="POST" action="{{ route('chamados.close', $chamado) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                                    Confirmar e Fechar Chamado
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    {{-- Modais permanecem no final --}}
    @include('chamados.partials.modal-resolve')
    @include('chamados.partials.modal-escalate')
    @include('chamados.partials.modal-reopen')

</x-app-layout>