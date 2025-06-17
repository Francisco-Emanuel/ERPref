<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-5">
            Ativos Visíveis
        </h2>
        {{-- Links para criar e para a lixeira --}}
        <x-nav-link :href="route('ativos.create')" :active="request()->routeIs('ativos.create')">
            Registrar Novo Ativo
        </x-nav-link>
        <x-nav-link :href="route('ativos.trash')" :active="request()->routeIs('ativos.trash')">
            Lixeira
        </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensagem de sucesso --}}
            @if(session('success'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($ativos as $ativo)
                    <div class="bg-gray-100 text-gray-900 shadow-md rounded-xl p-6 w-full max-w-sm flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-lg">{{ $ativo->nome_ativo }}</h2>
                            <span class="text-sm font-medium px-2 py-1 rounded-full 
                                {{ $ativo->status_condicao == 'Defeituoso' ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800' }}">
                                {{ $ativo->status_condicao }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                            <div>
                                <p class="font-semibold">Nº de Série</p>
                                <p>{{ $ativo->numero_serie }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Tipo</p>
                                <p>{{ $ativo->tipo_ativo }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Setor</p>
                                <p>{{ $ativo->setor->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Responsável</p>
                                {{-- Usando o relacionamento Eloquent --}}
                                <p>{{ $ativo->responsavel->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        @if ($ativo->descricao_problema)
                            <div>
                                <p class="font-semibold text-sm mb-1">Descrição do problema</p>
                                <p class="text-sm text-gray-700">{{ $ativo->descricao_problema }}</p>
                            </div>
                        @endif

                        <div class="mt-auto pt-4">
                            <a href="{{ route('ativos.edit', $ativo) }}"
                                class="w-full text-center block px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                                Editar
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Nenhum ativo encontrado.</p>
                @endforelse
            </div>
            
            {{-- Links de paginação --}}
            <div class="mt-6">
                {{ $ativos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>