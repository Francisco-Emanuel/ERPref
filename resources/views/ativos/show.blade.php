{{-- resources/views/ativos/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalhes do Ativo: {{ $ativo->nome_ativo }}
            </h2>
            <x-nav-link :href="route('ativos.index')">
                &larr; Voltar para a lista
            </x-nav-link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <h3 class="font-semibold text-gray-500">Nome do Ativo</h3>
                            <p class="text-lg text-gray-900">{{ $ativo->nome_ativo }}</p>
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-gray-500">Nº de Série</h3>
                            <p class="text-lg text-gray-900">{{ $ativo->numero_serie }}</p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-500">Tipo</h3>
                            <p class="text-lg text-gray-900">{{ $ativo->tipo_ativo }}</p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-500">Status (Condição)</h3>
                            <p class="text-lg font-bold {{ $ativo->status_condicao == 'Defeituoso' ? 'text-red-600' : 'text-green-600' }}">
                                {{ $ativo->status_condicao }}
                            </p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-500">Responsável</h3>
                            <p class="text-lg text-gray-900">{{ $ativo->responsavel->name ?? 'Nenhum' }}</p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-500">Setor</h3>
                            <p class="text-lg text-gray-900">{{ $ativo->setor->name ?? 'Nenhum' }}</p>
                        </div>

                        @if($ativo->descricao_problema)
                        <div class="md:col-span-2">
                            <h3 class="font-semibold text-gray-500">Descrição do Problema</h3>
                            <p class="text-gray-800 whitespace-pre-wrap">{{ $ativo->descricao_problema }}</p>
                        </div>
                        @endif

                    </div>

                    <div class="mt-8 border-t pt-6 flex justify-end">
                        <a href="{{ route('ativos.edit', $ativo) }}">
                           <x-primary-button>
                               Editar Ativo
                           </x-primary-button>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>