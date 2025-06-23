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
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Adicionar Atualização</h3>
                    <form method="POST" action="{{ route('chamados.updates.store', $chamado) }}">
                        @csrf
                        <textarea name="texto" rows="4" class="w-full border-gray-300 ... "
                            placeholder="..."></textarea>
                        <div class="mt-4 flex justify-end">
                            <x-primary-button>Enviar Atualização</x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Histórico do Chamado</h3>
                    <div class="space-y-6">
                        @forelse ($chamado->atualizacoes as $atualizacao)
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    {{-- Pode-se adicionar avatares aqui no futuro --}}
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600">
                                        {{ substr($atualizacao->autor->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="bg-gray-100 p-4 rounded-lg rounded-tl-none">
                                        <p class="text-sm text-gray-800">{{ $atualizacao->texto }}</p>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        <strong>{{ $atualizacao->autor->name }}</strong> &middot;
                                        {{ $atualizacao->created_at->format('d/m/Y \à\s H:i') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Nenhuma atualização neste chamado ainda.</p>
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
                                @if($chamado->status == 'Aberto') bg-green-100 text-green-800 @endif
                                @if($chamado->status == 'Em Andamento') bg-yellow-100 text-yellow-800 @endif
                                @if($chamado->status == 'Resolvido' || $chamado->status == 'Fechado') bg-gray-200 text-gray-800 @endif
                            ">{{ $chamado->status }}</dd>
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
                </div>
            </div>

        </div>
    </div>
</x-app-layout>