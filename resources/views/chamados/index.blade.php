<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Central de Chamados
        </h2>
        <x-nav-link :href="route('chamados.create')" :active="request()->routeIs('chamados.create')">
            Abrir Novo Chamado
        </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Título</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ativo Relacionado</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Técnico</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Data Abertura</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($chamados as $chamado)
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $chamado->id }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                    {{ $chamado->titulo }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    {{-- Acessando o ativo através do problema --}}
                                                                    {{ $chamado->problema->ativo->nome_ativo ?? 'N/A' }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{-- ALTERAÇÕES AQUI --}}
                                        @if($chamado->status == \App\Enums\ChamadoStatus::ABERTO) bg-green-100 text-green-800 @endif
                                        @if($chamado->status == \App\Enums\ChamadoStatus::EM_ANDAMENTO) bg-yellow-100 text-yellow-800 @endif
                                        @if($chamado->status == \App\Enums\ChamadoStatus::RESOLVIDO || $chamado->status == \App\Enums\ChamadoStatus::FECHADO) bg-gray-100 text-gray-800 @endif
                                    ">
                                                                        {{-- Esta linha não precisa mudar, pois o cast no modelo já converte para a
                                                                        string --}}
                                                                        {{ $chamado->status->value }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    {{ $chamado->tecnico->name ?? 'Não atribuído' }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    {{ $chamado->created_at->format('d/m/Y H:i') }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                    <a href="{{ route('chamados.show', $chamado) }}"
                                                                        class="text-indigo-600 hover:text-indigo-900">Ver Detalhes</a>
                                                                        {{-- Lógica para o botão de Atribuição --}}
                                                                    @can('edit-chamados')
                                                                        @if (!$chamado->tecnico_id)
                                                                            <form method="POST" action="{{ route('chamados.assign', $chamado) }}" class="inline-block">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                                <button type="submit" class="font-semibold text-green-600 hover:text-green-900">
                                                                                    Atribuir a mim
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Nenhum chamado
                                            encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $chamados->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>