<x-app-layout>
    {{-- O fundo da página segue o padrão do novo Dashboard --}}
    <div class="bg-slate-50 min-h-screen">

        {{-- Cabeçalho com o título e o botão de ação principal --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-slate-900">
                    Central de Chamados
                </h1>
                <div>
                    <x-nav-link :href="route('chamados.closed')" :active="request()->routeIs('chamados.closed')">
                        Chamados Fechados
                    </x-nav-link>
                    @can('edit-chamados') {{-- Apenas técnicos verão este link --}}
                        <x-nav-link :href="route('chamados.my')" :active="request()->routeIs('chamados.my')">
                            Meus Chamados
                        </x-nav-link>
                    @endcan
                </div>
                @can('create-chamados')
                    <a href="{{ route('chamados.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Abrir Novo Chamado
                    </a>
                @endcan
            </div>
        </header>

        {{-- Conteúdo Principal --}}
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Mensagem de sucesso --}}
                @if(session('success'))
                    <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-xl shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Card principal que envolve a tabela --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            {{-- Cabeçalho da tabela com o novo estilo --}}
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Título</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Técnico</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Última Atualização</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Prazo SLA</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Local</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            {{-- Corpo da tabela com linhas divididas sutilmente --}}
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($chamados as $chamado)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                            <span class="font-semibold text-blue-600">#{{ $chamado->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">
                                            {{ $chamado->titulo }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{-- Tags de status com cores atualizadas --}}
                                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                        @if($chamado->status == \App\Enums\ChamadoStatus::ABERTO) bg-green-100 text-green-800 @endif
                                                                                        @if($chamado->status == \App\Enums\ChamadoStatus::EM_ANDAMENTO) bg-yellow-100 text-yellow-800 @endif
                                                                                        @if($chamado->status == \App\Enums\ChamadoStatus::RESOLVIDO) bg-blue-100 text-blue-800 @endif
                                                                                    ">
                                                {{ $chamado->status->value }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                            {{ $chamado->tecnico->name ?? 'Não atribuído' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                            {{ $chamado->updated_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($chamado->prazo_sla)
                                                @php
                                                    $prazo = $chamado->prazo_sla;
                                                    $statusFinalizado = in_array($chamado->status, [\App\Enums\ChamadoStatus::RESOLVIDO, \App\Enums\ChamadoStatus::FECHADO]);
                                                    $texto_sla = '';
                                                    $cor_sla = '';

                                                    // Lógica para chamados já finalizados
                                                    if ($statusFinalizado) {
                                                        if ($chamado->data_resolucao && $chamado->data_resolucao->lte($prazo)) {
                                                            $texto_sla = 'Cumprido';
                                                            $cor_sla = 'text-green-600';
                                                        } else {
                                                            $texto_sla = 'Atrasado';
                                                            $cor_sla = 'text-red-600 font-bold';
                                                        }
                                                    }
                                                    // Lógica para chamados ainda abertos
                                                    else {
                                                        if ($prazo->isPast()) {
                                                            $texto_sla = 'Atrasado';
                                                            $cor_sla = 'text-red-600 font-bold';
                                                        } else {
                                                            // diffForHumans() cria texto como "em 2 horas" ou "em 1 dia"
                                                            $texto_sla = $prazo->diffForHumans();
                                                            // Muda a cor se faltar menos de 24h
                                                            $cor_sla = now()->diffInHours($prazo, false) <= 24 ? 'text-yellow-600 font-semibold' : 'text-blue-600';
                                                        }
                                                    }
                                                @endphp
                                                <span class="{{ $cor_sla }}">{{ $texto_sla }}</span>
                                            @else
                                                <span class="text-slate-500">Aguardando atribuição</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                            {{ $chamado->local }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold">
                                            <div class="flex items-center justify-end gap-4">
                                                <a href="{{ route('chamados.show', $chamado) }}"
                                                    class="text-blue-600 hover:text-blue-800">Ver Detalhes</a>

                                                @can('edit-chamados')
                                                    @if (!$chamado->tecnico_id) {{-- Se o chamado não tem técnico --}}
                                                        @if (Auth::user()->hasAnyRole(['Admin', 'Supervisor']))
                                                            {{-- Para Admins: Botão que abre o modal para atribuir a qualquer técnico
                                                            --}}
                                                            <button x-data
                                                                @click.stop="$dispatch('open-modal', 'atribuir-chamado-{{ $chamado->id }}')"
                                                                class="text-slate-500 hover:text-slate-700">
                                                                Atribuir
                                                            </button>
                                                        @else
                                                            {{-- Para Técnicos normais: Botão para se auto-atribuir --}}
                                                            <form method="POST" action="{{ route('chamados.assign', $chamado) }}"
                                                                class="inline-block" @click.stop>
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="text-slate-500 hover:text-slate-700">
                                                                    Atribuir a mim
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @else {{-- Se o chamado JÁ tem um técnico --}}
                                                        @if (Auth::user()->hasAnyRole(['Admin', 'Supervisor']))
                                                            {{-- Apenas Admins podem escalar um chamado já atribuído --}}
                                                            <button x-data
                                                                @click.stop="$dispatch('open-modal', 'escalate-chamado-{{ $chamado->id }}')"
                                                                class="text-red-600 hover:text-red-800">
                                                                Escalar
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-slate-500">Nenhum chamado
                                            encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{-- Paginação --}}
                    @if ($chamados->hasPages())
                        <div class="p-6 border-t border-slate-200">
                            {{ $chamados->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
    {{-- @foreach ($chamados as $chamado)
        <x-modal :name="'escalate-chamado-' . $chamado->id" focusable>
            <form method="post" action="{{ route('chamados.atribuir', $chamado) }}" class="p-6">
                @csrf
                @method('patch')
                <h2 class="text-lg font-medium text-gray-900">Atribuir / Escalar Chamado #{{ $chamado->id }}</h2>
                <p class="mt-1 text-sm text-gray-600">Selecione o técnico para quem você deseja transferir este chamado.</p>
                <div class="mt-6">
                    <x-input-label for="new_tecnico_id_{{ $chamado->id }}" value="Atribuir Para" />
                    <select id="new_tecnico_id_{{ $chamado->id }}" name="new_tecnico_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Selecione um técnico...</option>
                        @foreach ($tecnicosDisponiveis as $tecnico)
                            @if($chamado->tecnico_id !== $tecnico->id)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-danger-button class="ms-3">Confirmar</x-danger-button>
                </div>
            </form>
        </x-modal>
    @endforeach --}}

    @foreach ($chamados as $chamado)
        @include('chamados.partials.modal-atribuir', ['chamado' => $chamado])
    @endforeach
</x-app-layout>