<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detalhes do Chamado #{{ $chamado->id }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $chamado->titulo }}</p>
            </div>
            <x-nav-link :href="route('chamados.index')">
                &larr; Voltar para a lista de chamados
            </x-nav-link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Chat com o Solicitante</h3>

                    {{-- Formulário para enviar mensagem no chat --}}
                    <form method="POST" action="{{ route('chamados.updates.store', $chamado) }}">
                        @csrf
                        <textarea name="texto" rows="3" class="w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Digite sua mensagem para o solicitante..."></textarea>
                        <div class="mt-2 flex justify-end">
                            <x-primary-button>Enviar Mensagem</x-primary-button>
                        </div>
                    </form>

                    {{-- Exibição das mensagens do chat --}}
                    <div class="mt-6 space-y-6">
                        @forelse ($chatMessages as $message)
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600">
                                        {{ substr($message->autor->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <p class="text-sm text-gray-800">{{ $message->texto }}</p>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        <strong>{{ $message->autor->name }}</strong> &middot;
                                        {{ $message->created_at->format('d/m/Y \à\s H:i') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Nenhuma mensagem no chat ainda.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Histórico de Eventos</h3>
                    <div class="space-y-3">
                        @forelse ($historyLogs as $log)
                            <div
                                class="text-sm flex items-center justify-between p-2 rounded {{ $loop->odd ? 'bg-gray-50' : '' }}">
                                <p class="text-gray-700">{{ $log->texto }}</p>
                                <p class="text-xs text-gray-500 text-right flex-shrink-0 ml-4">
                                    {{ $log->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Nenhum evento de sistema registrado.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informações</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm font-semibold rounded-full px-2 py-1 inline-block
    {{-- ALTERAÇÕES AQUI --}}
    @if($chamado->status == \App\Enums\ChamadoStatus::ABERTO) bg-green-100 text-green-800 @endif
    @if($chamado->status == \App\Enums\ChamadoStatus::EM_ANDAMENTO) bg-yellow-100 text-yellow-800 @endif
    @if($chamado->status == \App\Enums\ChamadoStatus::RESOLVIDO || $chamado->status == \App\Enums\ChamadoStatus::FECHADO) bg-gray-200 text-gray-800 @endif
">
                                {{ $chamado->status->value }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Prioridade</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $chamado->prioridade }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Solicitante</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $chamado->solicitante->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Técnico Responsável</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $chamado->tecnico->name ?? 'Não atribuído' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Categoria</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $chamado->categoria?->nome_amigavel ?? 'Não definida' }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Problema de Origem</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Ativo</dt>
                            <dd class="mt-1 text-sm">
                                {{-- Verifica se o ativo existe antes de tentar usá-lo --}}
                                @if ($chamado->problema->ativo)
                                    <a href="{{ route('ativos.show', $chamado->problema->ativo) }}"
                                        class="text-indigo-600 hover:underline">
                                        {{ $chamado->problema->ativo->nome_ativo }}
                                    </a>
                                @else
                                    <span class="text-gray-500">Nenhum ativo vinculado</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Descrição do Problema</dt>
                            <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">
                                {{ $chamado->problema->descricao }}
                            </dd>
                        </div>
                    </dl>
                    @if(Auth::id() === $chamado->solicitante_id)
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ações do Solicitante</h3>

                            {{-- Botão para FECHAR um chamado resolvido --}}
                            @if($chamado->status === \App\Enums\ChamadoStatus::RESOLVIDO)
                                <p class="text-sm text-gray-600 mb-4">O problema foi resolvido? Clique abaixo para confirmar e
                                    fechar o chamado.</p>
                                <form method="POST" action="{{ route('chamados.close', $chamado) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-primary-button>Confirmar e Fechar Chamado</x-primary-button>
                                </form>
                            @endif

                            {{-- Botão para REABRIR um chamado fechado --}}
                            @if($chamado->status === \App\Enums\ChamadoStatus::FECHADO)
                                <p class="text-sm text-gray-600 mb-4">Se o problema retornou ou não foi totalmente resolvido,
                                    você pode reabrir o chamado.</p>
                                <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'reopen-chamado-modal')">
                                    Reabrir Chamado
                                </x-danger-button>
                            @endif
                        </div>
                    @endif
                    {{-- Formulário para Alterar Status (ADICIONAR ESTE BLOCO) --}}
                    @can('edit-chamados')
                        <div class="mt-6 border-t pt-6">
                            <h4 class="text-base font-semibold text-gray-800 mb-2">Alterar Status</h4>
                            <form method="POST" action="{{ route('chamados.updateStatus', $chamado) }}">
                                @csrf
                                @method('PATCH')

                                <div class="flex items-center gap-4">
                                    <select name="status" id="status"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                        {{-- Loop para exibir todas as opções do Enum --}}
                                        @foreach (App\Enums\ChamadoStatus::cases() as $status)
                                            <option value="{{ $status->value }}" @selected($chamado->status === $status)>
                                                {{ $status->value }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <x-primary-button>Salvar</x-primary-button>
                                </div>
                            </form>
                            {{-- Botão para Abrir o Modal de Resolução --}}

                            @if($chamado->status === \App\Enums\ChamadoStatus::EM_ANDAMENTO && $chamado->tecnico_id === Auth::id())
                                @can('close-chamados')
                                    <x-secondary-button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'resolve-chamado-modal')">
                                        Resolver Chamado
                                    </x-secondary-button>
                                @endcan

                                {{-- Botão para Abrir o Modal de Escalação --}}
                                <x-danger-button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'escalate-chamado-modal')">
                                    Escalar
                                </x-danger-button>
                            @endif
                        </div>
                    @endcan
                    {{-- Fim do Bloco Adicionado --}}
                </div>
            </div>

        </div>
    </div>
    <x-modal name="resolve-chamado-modal" focusable>
        <form method="post" action="{{ route('chamados.resolve', $chamado) }}" class="p-6">
            @csrf
            @method('patch')

            <h2 class="text-lg font-medium text-gray-900">
                Registrar Solução do Chamado #{{ $chamado->id }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Descreva detalhadamente a solução aplicada para resolver o problema do usuário. Esta informação será
                visível para o solicitante.
            </p>

            <div class="mt-6">
                <x-input-label for="solucao_final" value="Descrição da Solução" />
                <textarea id="solucao_final" name="solucao_final" rows="5"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required minlength="10">{{ old('solucao_final') }}</textarea>
                <x-input-error :messages="$errors->get('solucao_final')" class="mt-2" />
            </div>

            <div class="mt-6">
                <label for="servico_executado" class="flex items-center">
                    <input type="checkbox" id="servico_executado" name="servico_executado"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm" required>
                    <span class="ms-2 text-sm text-gray-700">Confirmo que o serviço foi executado e o problema
                        resolvido.</span>
                </label>
                <x-input-error :messages="$errors->get('servico_executado')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    Confirmar Resolução
                </x-primary-button>
            </div>
        </form>
    </x-modal>
    <x-modal name="escalate-chamado-modal" focusable>
        <form method="post" action="{{ route('chamados.escalate', $chamado) }}" class="p-6">
            @csrf
            @method('patch')

            <h2 class="text-lg font-medium text-gray-900">
                Escalar Chamado #{{ $chamado->id }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Selecione o técnico para quem você deseja transferir a responsabilidade deste chamado.
            </p>

            <div class="mt-6">
                <x-input-label for="new_tecnico_id" value="Atribuir Para" />
                <select id="new_tecnico_id" name="new_tecnico_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Selecione um técnico...</option>
                    @foreach ($tecnicosDisponiveis as $tecnico)
                        <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('new_tecnico_id')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Confirmar Escalação
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    <x-modal name="reopen-chamado-modal" focusable>
        <form method="post" action="{{ route('chamados.reopen', $chamado) }}" class="p-6">
            @csrf
            @method('patch')

            <h2 class="text-lg font-medium text-gray-900">
                Reabrir Chamado #{{ $chamado->id }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Por favor, descreva por que você precisa reabrir este chamado. O problema retornou ou a solução não foi eficaz?
            </p>

            <div class="mt-6">
                <x-input-label for="motivo_reabertura" value="Motivo da Reabertura" />
                <textarea id="motivo_reabertura" name="motivo_reabertura" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                <x-input-error :messages="$errors->get('motivo_reabertura')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Confirmar e Reabrir
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>