<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-5">
                Ativos
            </h2>
            {{-- Botão só aparece se o usuário puder criar ativos --}}
            @can('create-ativos')
                <x-nav-link :href="route('ativos.create')" :active="request()->routeIs('ativos.create')">
                    Cadastrar Ativo
                </x-nav-link>
            @endcan
            {{-- Botão só aparece se o usuário puder deletar ativos --}}
            @can('delete-ativos')
                <x-nav-link :href="route('ativos.trash')" :active="request()->routeIs('ativos.trash')" class="ml-4">
                    Lixeira
                </x-nav-link>
            @endcan
        </div>
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
                        {{-- ... (conteúdo do card continua o mesmo) ... --}}
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-lg">{{ $ativo->nome_ativo }}</h2>
                            <span
                                class="text-sm font-medium px-2 py-1 rounded-full 
                                    {{ $ativo->status_condicao == 'Defeituoso' ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800' }}">
                                {{ $ativo->status_condicao }}
                            </span>
                        </div>
                        {{-- ... --}}
                        <div class="mt-auto pt-4">
                            {{-- BOTÃO ALTERADO --}}
                            <a href="{{ route('ativos.show', $ativo) }}"
                                class="w-full text-center block px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Nenhum ativo encontrado.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $ativos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>